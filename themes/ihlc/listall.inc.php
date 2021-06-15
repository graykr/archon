<?php
isset($_ARCHON) or die();

	echo("<h1 id='titleheader'>" . strip_tags($_ARCHON->PublicInterface->Title) . "<br />");
	echo("Full list of collections in Archon <br />");
	echo("<span style='font-size:14px'>");
	echo date("Y-m-d H:i:s");
	echo("</span>");
	echo("</h1>\n");
?>
	

<div >

<?php
if(!$_ARCHON->Error)
   {
     $Characters = range('A','Z');
	 $Characters[] = "#";
	 $count = 0;
	 $publiccount = 0;
	 $arrExtentUnits = $_ARCHON->getAllExtentUnits();
	 
	echo("<table>");
	echo("<tr>
    <th>Published</th>
    <th>Collection Identifier</th>
    <th>Title</th>
	<th>Inclusive Dates</th>
    <th>Extent</th>
	<th>Scope (word count)</th>
    <th>Other URL</th>
	<th class='minimize-info'>Archon system ID</th>
  </tr>");
	 foreach($Characters as $Char) {  
         //echo("<table>");
		 $arrCollections = $_ARCHON->getCollectionsForChar($Char, false, $_SESSION['Archon_RepositoryID'], array('ID', 'Title', 'SortTitle', 'ClassificationID', 'InclusiveDates', 'CollectionIdentifier', 'RepositoryID', 'Extent', 'ExtentUnitID','OtherURL', 'Enabled', 'Scope'));
         
		

		if(!empty($arrCollections))
		{
         //echo("<div class='listitemhead bold'>$Char</div><br/><br/>\n<div id='listitemwrapper' class='bground'><div class='listitemcover'></div>\n");

         foreach($arrCollections as $objCollection)
         {
            //echo("<div class='listitem'>");
			$count++;
			echo("<tr>");
			echo("<td>");
			if($objCollection->Enabled)
			{
				$accessible = $objCollection->getString('Enabled');
				if($accessible == 1)
				{
					echo("Yes");
					$publiccount++;
				} else {
					echo("unpublished");
				}
			} else {
				echo("unpublished");
			}
			echo("</td><td>");
			if($objCollection->ClassificationID)
			{
				$objCollection->Classification = New Classification($objCollection->ClassificationID);
				//$objCollection->Classification->dbLoad(true);
				echo($_ARCHON->Error);
				echo($objCollection->Classification->toString(LINK_NONE, true, false, true, false) . '/');
			}
			//echo($objCollection->toString(LINK_TOTAL, true, false));
			if($objCollection->CollectionIdentifier)
			{
				echo("<a href='?p=collections/controlcard&amp;id=");
				echo($objCollection->getString('ID'));
				echo("'>");
				echo($objCollection->getString('CollectionIdentifier'));
				echo("</a>");
			}
			echo("</td><td>");
			if($objCollection->Title)
			{
				echo($objCollection->getString('Title'));
			}
			echo("</td><td>");
			if($objCollection->InclusiveDates)
			{
				echo($objCollection->getString('InclusiveDates'));
			}
			echo("</td><td>");
			if($objCollection->Extent)
			{
				echo(preg_replace('/\.(\d)0/', ".$1", $objCollection->getString('Extent')));
				if($objCollection->ExtentUnitID)
				{
					$objCollection->ExtentUnit = $arrExtentUnits[$objCollection->ExtentUnitID];
					echo($_ARCHON->Error);
					echo(" " . $objCollection->getString('ExtentUnit'));
				}
			}
			echo("</td><td>");
			if($objCollection->Scope)
			{
				echo(str_word_count($objCollection->getString('Scope')));
			}
			echo("</td><td>");
			if(!empty($objCollection->OtherURL))
			{
				echo("<a href='");
				echo($objCollection->getString('OtherURL'));
				echo("'>");
				echo($objCollection->getString('OtherURL'));
				echo("</a>");
			}
			echo("</td><td class='minimize-info'>");
			echo($objCollection->getString('ID'));
			//echo("</div>");
			echo("</td></tr>\n");
         }

         //echo("</div>\n");
		}
		//echo("</table>");
	 }
	 echo("</table>");
	 echo("<p>");
	 echo($count . " collections listed<br />");
	 echo($publiccount . " collections listed as published");
	 echo("</p>");
   }
?>

</div>