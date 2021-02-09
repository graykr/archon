<?php
// ***********************************************
// * Request link configuration *
// ***********************************************
// Note: Designed for Aeon, but would also work with any other request systems using forms that can be populated from GET requests

$_ARCHON->config->AddRequestLink = false;//set to true to add request links
$_ARCHON->config->RequestLinkText=""; //Example: "Submit request";
$_ARCHON->config->RequestURL = "";//Example: "https://aeon.library.university.edu/logon?Action=10&Form=30";

$_ARCHON->config->RequestVarTitle = "";//Example:"&ItemTitle=";
$_ARCHON->config->RequestVarIdentifier = "";//Example:"&CallNumber=";

//optional fields
$_ARCHON->config->RequestVarDates = "";//Example:"&ItemDate=";
$_ARCHON->config->RequestVarExtent = "";//Example:"&ItemInfo4=";
$_ARCHON->config->RequestVarRestrictions = "";//Example:"&SpecialRequest=";

$_ARCHON->config->RequestHasConsistentLocation = true;//set to false if using a custom location table
$_ARCHON->config->RequestVarLocation = "";//Example:"&Location=";
$_ARCHON->config->RequestDefaultLocation = "";//Example:"Archives";

$_ARCHON->config->RequestVarMaterialType ="";//Example:"&DocumentType=";

//define material types based on text in archon (only needed if changing the text for the request system)
$_ARCHON->config->RequestMaterialTypeList = array();//Example: array ('Official Records--Non-University' => 'Official Records','Personal Papers--Non-University' => 'Personal Papers',);

//Send box info from location table (if in use)
$_ARCHON->config->RequestVarBoxes = "";//Example:"&ItemInfo8=";

//define location codes to send based on the archon location ids; only if using custom location table
$_ARCHON->config->RequestLinkLocationList = array();//Example:array (100 => 'LIBRARY',203 => 'OFFSITE');
?>