<?php
isset($_ARCHON) or die();

	echo("<h1 id='titleheader'>" . strip_tags($_ARCHON->PublicInterface->Title) . "<br />");
	echo("Full list of collections in Archon, with scope and subjects (will load slowly)<br />");
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
	 
	 $GenreSubjectTypeID = $_ARCHON->getSubjectTypeIDFromString('Genre/Form of Material');
	 $GeogSubjectTypeID = $_ARCHON->getSubjectTypeIDFromString('Geographic Name');
	 $CorpSubjectTypeID = $_ARCHON->getSubjectTypeIDFromString('Corporate Name');
	 $NameSubjectTypeID = $_ARCHON->getSubjectTypeIDFromString('Personal Name');
	 $OccupationSubjectTypeID = $_ARCHON->getSubjectTypeIDFromString('Occupation');
	 $TopicalSubjectTypeID = $_ARCHON->getSubjectTypeIDFromString('Topical Term');
	 
	echo("<table id='listall-with-subjects'>");
	echo("<tr>
    <th>Published</th>
    <th>Collection Identifier</th>
    <th>Title</th>
	<th>Inclusive Dates</th>
    <th>Extent</th>
	<th>Scope (50 words)</th>
	<th>Genre/Form of Material</th>
	<th>Subjects - Geographic Name</th>
	<th>Subjects - Corporate Name</th>
	<th>Subjects - Personal Name</th>
	<th>Subjects - Occupation</th>
	<th>Subjects - Topical Term</th>
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
				$collTeaser ="";
				$lenTeaser = 50;
				$collScope = $objCollection->Scope;
				$scopeWords = explode(' ', $collScope);
				if (count($scopeWords) > $lenTeaser){
				   $scopeWords = array_slice($scopeWords, 0, $lenTeaser);
				   $collTeaser = implode(' ', $scopeWords);
				   $collTeaser .= " ...";
				} else {
					$collTeaser = $collScope;
				}
				echo($collTeaser);
			}
			echo("</td><td>");
			
			$objCollection->dbLoadSubjects();
			$arrGenres=array();
			$arrGeogSubj=array();
			$arrCorpSubj=array();
			$arrNameSubj=array();
			$arrOccupationSubj=array();
			$arrTopicalSubj=array();
			
			if(!empty($objCollection->Subjects)){	
				foreach($objCollection->Subjects as $objSubject){
				  if($objSubject->SubjectTypeID == $GenreSubjectTypeID)
				  {
					 $arrGenres[$objSubject->ID] = $objSubject;
				  } 
				  elseif($objSubject->SubjectTypeID == $GeogSubjectTypeID) 
				  {
					  $arrGeogSubj[$objSubject->ID] = $objSubject;
				  } 
				  elseif($objSubject->SubjectTypeID == $CorpSubjectTypeID)
				  {
					  $arrCorpSubj[$objSubject->ID] = $objSubject;
				  } 
				  elseif($objSubject->SubjectTypeID == $NameSubjectTypeID)
				  {
					  $arrNameSubj[$objSubject->ID] = $objSubject;
				  }
				  elseif($objSubject->SubjectTypeID == $OccupationSubjectTypeID)
				  {
					  $arrOccupationSubj[$objSubject->ID] = $objSubject;
				  }
				  elseif($objSubject->SubjectTypeID == $TopicalSubjectTypeID)
				  {
					  $arrTopicalSubj[$objSubject->ID] = $objSubject;
				  }
				}
			}	
				if(!empty($arrGenres)){
					echo(strip_tags($_ARCHON->createStringFromSubjectArray($arrGenres, "; ")));
				}
				echo("</td><td>");
				if(!empty($arrGeogSubj)){
					echo(strip_tags($_ARCHON->createStringFromSubjectArray($arrGeogSubj, "; ")));
				}
				echo("</td><td>");
				if(!empty($arrCorpSubj)){
					echo(strip_tags($_ARCHON->createStringFromSubjectArray($arrCorpSubj, "; ")));
				}
				echo("</td><td>");
				if(!empty($arrNameSubj)){
					echo(strip_tags($_ARCHON->createStringFromSubjectArray($arrNameSubj, "; ")));
				}
				echo("</td><td>");
				if(!empty($arrOccupationSubj)){
					echo(strip_tags($_ARCHON->createStringFromSubjectArray($arrOccupationSubj, "; ")));
				}
				echo("</td><td>");
				if(!empty($arrTopicalSubj)){
					echo(strip_tags($_ARCHON->createStringFromSubjectArray($arrTopicalSubj, "; ")));
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