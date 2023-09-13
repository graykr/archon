<?php
isset($_ARCHON) or die();

	echo("<h1 id='titleheader'>" . strip_tags($_ARCHON->PublicInterface->Title) . "<br />");
	echo("List of CHSTM subjects in Archon with EAD links<br />");
	echo("<span style='font-size:14px'>");
	echo date("Y-m-d H:i:s");
	echo("</span>");
	echo("</h1>\n");
?>
	

<div >

<?php
if(!$_ARCHON->Error)
   {
	echo("<table id='list-subjects'>");
	echo("<tr>
    <th>Subject ID</th>
    <th>Subject</th>
	<th>Collection count</th>
	<th>Collection EAD Links</th>
  </tr>");

	if($_ARCHON->config->CHSTMSubjectList){
		$arrTermsCHSTM = $_ARCHON->config->CHSTMSubjectList;
	} else {
		$arrTermsCHSTM = array("4099");
	}
	
	$arrResultsCHSTM = array();

	foreach($arrTermsCHSTM as $chstmTermID) {
		$objSubject = New Subject($chstmTermID);
      	$objSubject->dbLoad();
		echo("<tr><td>");
		if($objSubject->ID)
		{
			echo("<a href='index.php?p=subjects/subjects&id=".$objSubject->ID."' target='_blank'>".$objSubject->ID."</a>");
		}
		echo("</td><td>");
		if($objSubject->Subject)
		{
			echo($objSubject->toString(LINK_NONE, true));
		}
		echo("</td><td>");
		
		if($objSubject->ID)
		{
			$subjectResults=array();
			$subjectResults=$_ARCHON->searchCollections(NULL, SEARCH_ENABLED_COLLECTIONS, $objSubject->ID);
			echo(count($subjectResults));
			echo("</td><td>");
			foreach($subjectResults as $subjResult){
				array_push($arrResultsCHSTM,$subjResult->ID);
				echo("<a href='index.php?p=collections/ead&id={$subjResult->ID}&templateset=ead&disabletheme=1&output={$subjResult->ID}'>");
				echo($subjResult->Title);
				echo("</a>");
				echo("<br />");
			}
		}
		echo("</td></tr>\n");
    }
	 echo("</table>");
   }
  ?>

</div>