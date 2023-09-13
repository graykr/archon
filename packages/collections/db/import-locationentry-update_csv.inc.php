<?php
/**
 * Location entry importer script.
 *
 * This script takes .csv files in defined formats and updates the existing location entry record for each row in the database.
 * Sample csv/excel files are provided in the archon/incoming folder, to show the necessary format.
 * 
 * Note: Updating by barcode (shelf value) requires defining a function getLocationEntryIDFromShelf
 * This has been added to packages\collections\lib\core\archon.php (line 1288)
 *
 * @package Archon
 * @subpackage AdminUI
 * @author Krista Gray
 */

isset($_ARCHON) or die();


$UtilityCode = 'locationentry-update_csv';

$_ARCHON->addDatabaseImportUtility(PACKAGE_COLLECTIONS, $UtilityCode, '3.21', array('csv'), true);



if($_REQUEST['f'] == 'import-' . $UtilityCode)
{
    if(!$_ARCHON->Security->verifyPermissions(MODULE_DATABASE, FULL_CONTROL))
    {
        die("Permission Denied.");
    }


    @set_time_limit(0);

    ob_implicit_flush();

    $arrFiles = $_ARCHON->getAllIncomingFiles();

    if(!empty($arrFiles))
    {
        $arrLocations = $_ARCHON->getAllLocations();
        foreach($arrLocations as $objLocation)
        {
            $arrLocationsMap[encoding_strtolower($objLocation->Location)] = $objLocation->ID;
        }
        
        $arrExtentUnits = $_ARCHON->getAllExtentUnits();
        foreach($arrExtentUnits as $objExtentUnit)
        {
            $arrExtentUnitsMap[encoding_strtolower($objExtentUnit->ExtentUnit)] = $objExtentUnit->ID;
        }

        $arrFieldHeadings = array (
            1 => 'LocationEntryID',
            2 => 'Content',
            3 => 'Location',
            4 => 'Range',
            5 => 'Section',
            6 => 'Shelf',
            7 => 'Extent',
            8 => 'ExtentUnit',
        );

        foreach($arrFiles as $Filename => $strCSV)
        {
            echo("Parsing file $Filename...<br><br>\n\n");

            // Remove byte order mark if it exists.
            $strCSV = ltrim($strCSV, "\xEF\xBB\xBF");

            $arrAllData = getCSVFromString($strCSV);

            $firstLine = true;
            $locationDataFormat = '';
            $csvFormatCorrect = false;//assume it is wrong until we confirm it is correct

            foreach($arrAllData as $arrData)
            {
                //if first line then test to determine data format
                if($firstLine && !empty($arrData)) {
                    
                    if(count($arrData)<4){
                        echo("CSV column heading error: First four column headings are required (even if either LocationEntry or Content can be blank).<br>\n");
                        $csvFormatCorrect = false;
                    } else {

                        $columnHeading1 = trim(reset($arrData));
                        echo("Importing location entries via ".$columnHeading1."<br><br>\n\n");

                        if($columnHeading1 == 'Identifier') {
                            $locationDataFormat = 'Identifier';
                        } elseif($columnHeading1 == 'ArchonID'){
                            $locationDataFormat = 'ArchonID';
                        } elseif($columnHeading1 == 'Barcode'){
                            $locationDataFormat = 'Barcode';
                        } else {
                            echo("CSV column heading error: ".$columnHeading1." should be Identifier, ArchonID, or Barcode.<br>\n");
                            $csvFormatCorrect = false;
                        }


                        for($j=1; $j < count($arrData); $j++){
                            if($j<4 AND ($arrData[$j] != $arrFieldHeadings[$j])){
                                echo("CSV column heading error: ".$arrData[$j]." should be ".$arrFieldHeadings[$j].".<br>\n");
                                $csvFormatCorrect = false;
                                break;
                            }
                            elseif(!empty($arrData[$j]) AND ($arrData[$j] != $arrFieldHeadings[$j])) {
                                echo("CSV column heading error: ".$arrData[$j]." should be ".$arrFieldHeadings[$j]." or empty.<br>\n");
                                $csvFormatCorrect = false;
                                break;
                            }
                            $csvFormatCorrect = true;
                        }

                    }
                    $firstLine = false;
                } 
                elseif(!empty($arrData) AND $csvFormatCorrect)
                {

                    $objLocationEntry = New LocationEntry();
                    
                    /* FIND THE COLLECTION OR RECORD SERIES ID BASED ON FIRST COLUMN*/
                    if($locationDataFormat == 'Identifier'){
                        $RecordSeriesNumber = trim(reset($arrData));
                        $objCollectionArchonID = $_ARCHON->getCollectionIDForNumber($RecordSeriesNumber);
                        if(!$objCollectionArchonID)
                        {
                            echo("Collection '" . $RecordSeriesNumber . "' not found!<br>\n");
                            continue;
                        }
                    } elseif($locationDataFormat == 'ArchonID') {
                        $objCollectionArchonID = trim(reset($arrData));
                    } elseif($locationDataFormat == 'Barcode') {
                        $BarcodeValue = trim(reset($arrData));
                        $BarcodeLocationEntryID = $_ARCHON->getLocationEntryIDFromShelf($BarcodeValue);
                        if($BarcodeLocationEntryID == 0){
                            echo("Barcode '".$BarcodeValue."' not associated with a location entry.<br>\n");
                            flush();
                            continue;
                        } else {
                            $objLocationEntry->ID = $BarcodeLocationEntryID;
                            if(!$objLocationEntry->dbLoad()){
                                echo("Error retrieving LocationEntry from Barcode: {$_ARCHON->clearError()}<br>\n");
                                flush();
                                continue;
                            } else {
                                $objCollectionArchonID = $objLocationEntry->CollectionID;
                            }
                        }
                    }

                    $objCollection = new Collection ($objCollectionArchonID);
                    if(!$objCollection->dbLoad()){
                        echo("Error retrieving collection for line beginning with ".$arrData[0].". Location entry not imported.<br>\n");
                        flush();
                        continue;
                    }
					
					/* CREATE NEW LOCATION ENTRY OR RETRIEVE EXISTING */
					$LocationEntryID = trim(next($arrData));

                    if($locationDataFormat != 'Barcode' AND !empty($LocationEntryID)){
                        $objLocationEntry->ID = $LocationEntryID;
                        if(!$objLocationEntry->dbLoad()){
                            echo("Error retrieving LocationEntry: {$_ARCHON->clearError()}<br>\n");
                            flush();
                            continue;
                        }
                    } else {
                        if(!empty($LocationEntryID)){
                            if($LocationEntryID != $BarcodeLocationEntryID)
                            {
                                echo("Barcode and LocationEntry ID mismatch. Location not updated for barcode $BarcodeValue and location entry id $LocationEntryID. Please check csv file.<br>\n");
                                flush();
                                continue;
                            }
                        } elseif($objLocationEntry->ID) {
                            $LocationEntryID = $objLocationEntry->ID;
                        }
                    }
                    
                    $LocationContent = trim(next($arrData));

                    if (!empty($LocationContent) OR !empty($LocationEntryID))
                    {
                        $Location = trim(next($arrData));
                        $RangeValue = trim(next($arrData));
                        $SectionValue = trim(next($arrData));
                        $ShelfValue = trim(next($arrData));
                        $ExtentValue = trim(next($arrData));
                        $ExtentUnitValue = trim(next($arrData));

                        if(!empty($Location)){
                            $objLocationEntry->LocationID = $arrLocationsMap[encoding_strtolower($Location)] ? $arrLocationsMap[encoding_strtolower($Location)] : 0;
                        }

                        if($objLocationEntry->LocationID != 0)
                        {
                            //only overwrite field values for location entry if those from CSV are not blank
                            if(!empty($LocationContent)){
                                $objLocationEntry->Content = $LocationContent;
                            }
                            
                            if(!empty($RangeValue)){
                                $objLocationEntry->RangeValue = $RangeValue;
                            }

                            if(!empty($SectionValue)){
                                $objLocationEntry->Section = $SectionValue;
                            }
                            
                            if(!empty($ShelfValue)){
                                $objLocationEntry->Shelf = $ShelfValue;
                            }

                            if(!empty($ExtentValue)){
                                $objLocationEntry->Extent = $ExtentValue;
                            }
                            
                            if(!empty($ExtentUnitValue)){
                                $objLocationEntry->ExtentUnitID = $arrExtentUnitsMap[encoding_strtolower($ExtentUnitValue)] ? $arrExtentUnitsMap[encoding_strtolower($ExtentUnitValue)] : 0;
                                if(!$objLocationEntry->ExtentUnitID && $ExtentUnitValue)
                                {
                                    echo("Extent Unit '$ExtentUnitValue' not found!<br>\n");
                                }
                            }
                        }
                        else
                        {
                            echo("Location '$Location' not found (line beginning with ".$arrData[0].")<br>\n");
                            $objLocationEntry = NULL;
                        }
                    } else {
                        echo("Error with line beginning with ".$arrData[0].". Content value required for new Location Entries.<br>\n");
                        $objLocationEntry = NULL;
                    }

                    if(!empty($objLocationEntry) AND !empty($objLocationEntry->CollectionID)){
                        if(!empty($objCollectionArchonID)){
                            if($objCollectionArchonID != $objLocationEntry->CollectionID){
                                echo("Location Entry ".$objLocationEntry->ID." not updated. ArchonID mismatch. Existing ArchonID for LocationEntry is ".$objLocationEntry->CollectionID." but CSV entry is for ".$objCollectionArchonID.".<br>\n");
                                $objLocationEntry = NULL;
                            }
                        } else {
                            $objLocationEntry = NULL;
                        }
                    } elseif($objLocationEntry) {
                        $objLocationEntry->CollectionID = $objCollectionArchonID;
                    }

                    if(!empty($objLocationEntry)) {
                        if(empty($objLocationEntry->ID)){
                            echo("Creating new location entry...<br>\n");
                        } else {
                            echo("Updating location entry...<br>\n");
                        }
                    }

                    if($objLocationEntry)
                    {
                        if(!$objLocationEntry->dbStore())
                        {
                            echo("Error relating LocationEntry to collection: {$_ARCHON->clearError()}<br>\n");
                        } else { 
							echo("Imported location information for {$LocationContent} of  {$objCollection->toString()}.<br><br>\n\n");
						}
                        
                    }


                    flush();
                }
            }
        }

        echo("All files processed!");
    }
}

?>