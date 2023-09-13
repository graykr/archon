<?php

	echo("<table id='location-bulk-upload' class='simple-table'>");
	echo("<tr>
    <th>Identifier</th>
    <th>LocationEntryID</th>
    <th>Content</th>
	<th>Location</th>
    <th>Range</th>
	<th>Section</th>
	<th>Shelf</th>
	<th>Extent</th>
	<th>ExtentUnit</th>
  	</tr><tbody>");

	if(!empty($objCollection->LocationEntries)){
		foreach($objCollection->LocationEntries as $objLocationEntry){
			echo("<tr>");
			echo("<td>");
			if($objCollection->ClassificationID)
			{
				$objCollection->Classification = New Classification($objCollection->ClassificationID);
				echo($_ARCHON->Error);
				echo($objCollection->Classification->toString(LINK_NONE, true, false, true, false) . '/');
			}
			if($objCollection->CollectionIdentifier)
			{
				echo($objCollection->getString('CollectionIdentifier'));
			}
			echo("</td><td>");
			
			echo($objLocationEntry->getString('ID'));

			echo("</td><td>");

			echo($objLocationEntry->getString('Content'));

			echo("</td><td>");
			if($objLocationEntry->LocationID && !$objLocationEntry->Location)
			{
				$objLocationEntry->Location = New Location($objLocationEntry->LocationID);
				$objLocationEntry->Location->dbLoad();
			}
			
			echo($objLocationEntry->Location->toString());

			echo("</td><td>");
			if(isset($objLocationEntry->RangeValue)){
				echo($objLocationEntry->getString('RangeValue'));
			}

			echo("</td><td>");
			if(isset($objLocationEntry->Section)){
        		echo($objLocationEntry->getString('Section'));
			}

			echo("</td><td>");
			if(isset($objLocationEntry->Shelf)){
        		echo($objLocationEntry->getString('Shelf'));
			}

			echo("</td><td>");
			if(isset($objLocationEntry->Extent)){
        		echo($objLocationEntry->getString('Extent'));
			}

			echo("</td><td>");
			
			if($objLocationEntry->ExtentUnitID){
				if(!$objLocationEntry->ExtentUnit)
				{
					$objLocationEntry->ExtentUnit = New ExtentUnit($objLocationEntry->ExtentUnitID);
					$objLocationEntry->ExtentUnit->dbLoad();
				}
				echo($objLocationEntry->ExtentUnit->toString());
			}

			echo("</td>");

			echo("</tr>\n");
		}
	}
	echo("</tbody></table>");

?>