<?php
isset($_ARCHON) or die();

	echo("<h1 id='titleheader'>" . strip_tags($_ARCHON->PublicInterface->Title) . "<br />");
	echo("Full list of subjects in Archon (will load slowly)<br />");
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
    <th>Subject Type</th>
	<th>Subject Source</th>
	<th>Collection count</th>
  </tr>");
  	 
	$arrSubjects = $_ARCHON->getAllSubjects();
	$arrSubjectTypes = $_ARCHON->getAllSubjectTypes();
	$arrSubjectSources = $_ARCHON->getAllSubjectSources();

	
	foreach($arrSubjects as $objSubject){ 
	 	echo("<tr>");
		echo("<td>");
		if($objSubject->ID)
		{
			echo("<a href='index.php?p=subjects/subjects&id=".$objSubject->ID."' target='_blank'>".$objSubject->ID."</a>");
		}
		echo("</td><td>");
		if($objSubject->Subject)
		{
			echo($objSubject->Subject);
		}
		echo("</td><td>");
		if($objSubject->SubjectTypeID)
		{
			echo($arrSubjectTypes[$objSubject->SubjectTypeID]->SubjectType);
		}
		echo("</td><td>");
		if($objSubject->SubjectSourceID)
		{
			echo($arrSubjectSources[$objSubject->SubjectSourceID]->SubjectSource);
		}
		echo("</td><td>");
		
		if($objSubject->ID)
		{
			$subjectResults=array();
			$subjectResults=$_ARCHON->searchCollections(NULL, SEARCH_COLLECTIONS, $objSubject->ID);
			echo(count($subjectResults));
		}
		echo("</td></tr>\n");
    }
	 echo("</table>");
   }
  ?>

</div>