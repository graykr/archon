<?php
$searchParams = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING); 

$primoArray = array("query"=>"any,contains,".$searchParams["lookfor"]);
if($searchParams['sort']=="year_asc")
{
	$primoArray["sortby"]="date_a";
}
if(array_key_exists("location",$searchParams)){
	$catLocation = $searchParams["location"];
	if($catLocation == "uiu_hsurvey"){
		$primoArray["mfacet"]="library,include,5899–160739450005899,1";
		$primoScopeString =  "&tab=SPCOLLECTIONS&search_scope=SPCOLLECTIONS&vid=01CARLI_UIU:UIU_SPCOLLECTIONS&offset=0";
	} elseif($catLocation == "spec") {
		$primoScopeString =  "&tab=SPCOLLECTIONS&search_scope=SPCOLLECTIONS&vid=01CARLI_UIU:UIU_SPCOLLECTIONS&offset=0";
	} else {
		$primoScopeString =  "&tab=LibraryCatalog&search_scope=MyInstitution&vid=01CARLI_UIU:CARLI_UIU&lang=en&mode=basic&offset=0";
	}
} else {
	$primoScopeString =  "&tab=LibraryCatalog&search_scope=MyInstitution&vid=01CARLI_UIU:CARLI_UIU&lang=en&mode=basic&offset=0";
}
$primoSearchString = http_build_query($primoArray);

if(array_key_exists("dateRange",$searchParams)){
	$dateCentury=$searchParams["dateRange"];
	if($dateCentury=="1600s"){
		$centuryString="&pfilter=cdate,exact,16000101,AND&pfilter=cdate,exact,16991231,AND";
	} elseif($dateCentury=="1700s"){
		$centuryString="&pfilter=cdate,exact,17000101,AND&pfilter=cdate,exact,17991231,AND";
	} elseif($dateCentury=="1800s"){
		$centuryString="&pfilter=cdate,exact,18000101,AND&pfilter=cdate,exact,18991231,AND";
	} elseif($dateCentury=="1900s"){
		$centuryString="&pfilter=cdate,exact,19000101,AND&pfilter=cdate,exact,19991231,AND";
	} elseif($dateCentury=="2000s"){
		$centuryString="&pfilter=cdate,exact,20000101,AND&pfilter=cdate,exact,20991231,AND";
	}
}
$primoSearchString .= $centuryString .$primoScopeString;



$primoSearchURL = "https://i-share-uiu.primo.exlibrisgroup.com/discovery/search?" . $primoSearchString;
echo("<p>Processing custom Library Catalog search...<br />");
echo('<a href="'.$primoSearchURL.'">Click here to continue to search results if not redirected in 5 seconds.</a></p>');
echo('<script>window.location.replace("'.$primoSearchURL.'")</script>');
?>
