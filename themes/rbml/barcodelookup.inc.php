<?php

/*
* Note: this code uses the getLocationEntryIDFromShelf($BarcodeValue) function
 * This has been defined in packages\collections\lib\core\archon.php (7/28/2021)
*/

isset($_ARCHON) or die();

	echo("<div id='searchresults'>");
	echo("<h1 id='titleheader'>" . "Barcode Lookup | " . strip_tags($_ARCHON->PublicInterface->Title) . "<br />");
	echo("<span style='font-size:14px'>");
	echo("</span>");
	echo("</h1>\n");
?>
	

<div >

<div style="width:auto; font-size:100%; text-align:center" class="bground textcontainer">
<?php
if(!$_ARCHON->Error)
   if(!$_REQUEST['barcode'])
{
    echo("Error with search query.");
	echo("<p><a href='?p=core/index'>Return to main search page</a></p>");
}
else
{
    $BarcodeValue = encode($_REQUEST['barcode'], ENCODE_HTML)+0;
	if(is_numeric($BarcodeValue)) {
		$BarcodeLocationEntryID = $_ARCHON->getLocationEntryIDFromShelf($BarcodeValue);
		if($BarcodeLocationEntryID == 0){
			echo("<p>Barcode ".$BarcodeValue." not found.</p>");
			echo("<p><a href='?p=core/index'>Return to main page</a></p>");
		} else {
			$objLocationEntry = New LocationEntry();
			$objLocationEntry->ID = $BarcodeLocationEntryID;
			if(!$objLocationEntry->dbLoad()){
				echo("<p>Error retrieving LocationEntry from Barcode.</p>");
				echo("<p><a href='?p=core/index'>Return to main page</a></p>");
			} else {
				$objCollection = New Collection($objLocationEntry->CollectionID);
			}
			if($objCollection->dbLoad()){
				echo("<h2>Location Entry Found for Barcode ".$BarcodeValue."</h2>");
				echo("<p>");
				
				//add the record series number
				if($objCollection->ClassificationID) { 
					$objCollection->Classification = New Classification($objCollection->ClassificationID);
					$objCollection->Classification->dbLoad();
					echo($objCollection->Classification->toString(LINK_NONE, true, false, true, false) . '/');
				}
		
				//print the collection or record series identifier and title
				echo($objCollection->toString(LINK_TOTAL, true));
				echo("<br>");

				if($objLocationEntry->LocationID && !$objLocationEntry->Location->Description)
				{
					$objLocationEntry->Location = New Location($objLocationEntry->LocationID);
					$objLocationEntry->Location->dbLoad();
				}

				$objLocationPhrase = Phrase::getPhrase('locationentries_location', PACKAGE_COLLECTIONS, 0, PHRASETYPE_ADMIN);
				$strLocation =  $objLocationPhrase ? $objLocationPhrase->getPhraseValue(ENCODE_HTML) : 'Location';
				$objRangeValuePhrase = Phrase::getPhrase('locationentries_rangevalue', PACKAGE_COLLECTIONS, 0, PHRASETYPE_ADMIN);
				$strRangeValue =  $objRangeValuePhrase ? $objRangeValuePhrase->getPhraseValue(ENCODE_HTML) : 'Range';
				$objSectionPhrase = Phrase::getPhrase('locationentries_section', PACKAGE_COLLECTIONS, 0, PHRASETYPE_ADMIN);
				$strSection =  $objSectionPhrase ? $objSectionPhrase->getPhraseValue(ENCODE_HTML) : 'Section';
				$objShelfPhrase = Phrase::getPhrase('locationentries_shelf', PACKAGE_COLLECTIONS, 0, PHRASETYPE_ADMIN);
				$strShelf =  $objShelfPhrase ? $objShelfPhrase->getPhraseValue(ENCODE_HTML) : 'Shelf';
				
				?>
				<table id='locationtable' border='1' style="margin-left: auto;margin-right: auto;">
                     <tr>
                        <th>Content</th>
                        <th><?php echo($strLocation);?></th>
                        <th><?php echo($strRangeValue);?></th>
                        <th><?php echo($strSection);?></th>
                        <th><?php echo($strShelf);?></th>
                        <th>Extent</th>
                     </tr>
                     <tr>
                        <td>
     					<?php echo($objLocationEntry->toString(LINK_EACH, false, '&nbsp;</td><td>')); ?>
                        </td>
                     </tr>
                  </table>
				<?php
				echo("</p>");
			}
			echo("<p><a href='?p=core/index'>Return to main page</a></p>");
		}
	} else {
		echo("Error! Barcode must be a number.");
		echo("<p><a href='?p=core/index'>Return to main page</a></p>");
	}
	
}
echo("</div>");
?>
</div>
</div>