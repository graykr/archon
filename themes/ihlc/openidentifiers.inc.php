<?php
isset($_ARCHON) or die();

	echo("<h1 id='titleheader'>" . strip_tags($_ARCHON->PublicInterface->Title) . "<br />");
	echo("Collection Identifiers <br />");
	echo date("Y-m-d H:i:s");
	echo("</h1>\n");
?>
	

<div >

<?php
if(!$_ARCHON->Error)
   {
     $Characters = range('A','Z');
	 $Characters[] = "#";
	 
	 //$arrIdentifiers = array_fill(100,1200,'open');//testing
	 $arrIdentifiers = array();
	
	 foreach($Characters as $Char) {  
         
		 $arrCollections = $_ARCHON->getCollectionsForChar($Char, false, $_SESSION['Archon_RepositoryID'], array('ID', 'Title', 'CollectionIdentifier'));
         
		

		if(!empty($arrCollections))
		{
        

         foreach($arrCollections as $objCollection)
         {
            
			
			if($objCollection->CollectionIdentifier)
			{
				
				$identifier = $objCollection->getString('CollectionIdentifier');
				
			}
			
			if($objCollection->Title)
			{
				$title = "<a href='?p=collections/controlcard&amp;id=";
				$title .= $objCollection->getString('ID');
				$title .= "'>";
				$title .= $objCollection->getString('Title');
				$title .= "</a>";
			}
			
			$arrIdentifiers[$identifier] = $title;
         }


		}

	 }
	 
	 //create table to display
	 //uksort($arrIdentifiers, 'strnatcmp');
	 //print_r($arrIdentifiers);
	 
	//create comparison list
	$maxidentifier = 1200;
	
	echo("Jump to:");
	echo("<ul class='jump_100'>");
	for($j=100; $j <= $maxidentifier; $j += 100) {
		echo("<li><a href='#".$j."id'>".$j."</a></li>");
	}
	echo("</ul>");
	
	echo("<table>");
	for ($i = 1; $i <= $maxidentifier; $i++) {
		$padded_i = str_pad($i, 3, "0", STR_PAD_LEFT);
		echo("<tr>");
		echo("<td>");
		if ($i % 100 == 0 ){
			echo("<a id='".$i."id'>".$padded_i."</a>");
		} else {
			echo($padded_i);
		}
		echo("</td><td>");
		if(isset($arrIdentifiers[$padded_i])) 
		{
			echo($arrIdentifiers[$padded_i]);
		} else {
			echo('OPEN');
			echo("<a href='?p=admin/collections/collections&selectedtab=1' rel='external' class='create-button'>Create new collection</a>");
		}
		echo("</td></tr>\n");
   }
   echo("</table>");
   }
?>

</div>