<?php
isset($_ARCHON) or die();
	echo("<div id='searchresults'>");
	echo("<h1 id='titleheader'>" . "Search by Collection Identifier | " . strip_tags($_ARCHON->PublicInterface->Title) . "<br />");
	//echo("Search by Collection Identifier <br />");
	echo("<span style='font-size:14px'>");
	echo("</span>");
	echo("</h1>\n");
?>
	

<div >

<div style="width:auto; font-size:100%; text-align:center" class="bground textcontainer">
<?php
if(!$_ARCHON->Error)
   if(!$_REQUEST['q'])
{
    echo("Error with search query.");
	echo("<p><a href='?p=core/index'>Return to main search page</a></p>");
}
else
{
    $potentialidentifier = encode($_REQUEST['q'], ENCODE_HTML);
	if(is_numeric($potentialidentifier)) {
		$potentialID = $_ARCHON->getCollectionIDForNumber($potentialidentifier+0);// adding 0 to remove leading zero from text input
		if($potentialID >0) {
			$objCollection = New Collection($potentialID);
			$objCollection->dbLoad();
			echo("<p>Collection Identifier ".$potentialidentifier."</p><p>");
			echo("<span style='font-size:125%'>Go to: ");
			echo($objCollection->toString(true, false, false)."</span>");
			echo("</p>");
		} else {
			echo("Sorry! Identifier ".$potentialidentifier." not found.");
			echo("<p><a href='?p=core/index'>Return to main search page</a></p>");
		}
	} else {
		echo("Error! Collection Identifier must be a number.");
		echo("<p><a href='?p=core/index'>Return to main search page</a></p>");
	}
	
}
echo("</div>");
?>
</div>
</div>