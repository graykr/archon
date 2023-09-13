<?php
isset($_ARCHON) or die();

echo("<div>");
if(!$_ARCHON->Error)
   {

	if($_ARCHON->config->CHSTMSubjectList){
		$arrTermsCHSTM = $_ARCHON->config->CHSTMSubjectList;
	} else {
		$arrTermsCHSTM = array("120");
	}
	
	$arrResultsCHSTM = array();

	foreach($arrTermsCHSTM as $chstmTermID) {
		$objSubject = New Subject($chstmTermID);
      	$objSubject->dbLoad();
		
		if($objSubject->ID)
		{
			$subjectResults=array();
			$subjectResults=$_ARCHON->searchCollections(NULL, SEARCH_ENABLED_COLLECTIONS, $objSubject->ID);
			foreach($subjectResults as $subjResult){
				array_push($arrResultsCHSTM,$subjResult->ID);
			}
		}
    }

	 $uniqueArrResultsCHSTM = array_unique($arrResultsCHSTM);

	 foreach($uniqueArrResultsCHSTM as $resultCHSTM){
		echo("<a href='index.php?p=collections/ead&id={$resultCHSTM}&templateset=ead&disabletheme=1&output={$resultCHSTM}'>");
		echo($resultCHSTM);
		echo("</a><br />");
	 }
   }
  ?>

</div>