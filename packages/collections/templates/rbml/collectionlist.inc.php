<?php
/**
 * Collection List template
 *
 * The variable:
 *
 *  $objCollection
 *
 * is an instance of a Collection object, with its properties
 * already loaded when this template is referenced.
 *
 * Refer to the Collection class definition in lib/collection.inc.php
 * for available properties and methods.
 *
 * The Archon API is also available through the variable:
 *
 *  $_ARCHON
 *
 * Refer to the Archon class definition in lib/archon.inc.php
 * for available properties and methods.
 *
 * @package Archon
 * @author Chris Rishel
 */

isset($_ARCHON) or die();

echo("<div class='listitem'>");
if($objCollection->ClassificationID)
{
    $objCollection->Classification = New Classification($objCollection->ClassificationID);
    //$objCollection->Classification->dbLoad(true);
    echo($_ARCHON->Error);
    echo($objCollection->Classification->toString(LINK_NONE, true, false, true, false) . '/');
}
/*echo($objCollection->toString(LINK_TOTAL, true, false));*/

if($_ARCHON->config->CollectionDetailList) {

/* add details to list display */
	
	$detailMakeIntoLink = true;
	$detailConcatinateCollectionIdentifier = true;
	$detailUseSortTitle = false;
	
	$details = $objCollection->toString($detailMakeIntoLink, $detailConcatinateCollectionIdentifier, $detailUseSortTitle);
	  
	  if(!$objCollection->Extent || !$objCollection->ExtentUnit || !$objCollection->AltExtentStatement)
      {
         $objCollection->dbLoad();
      }
	  
	  if($objCollection->ExtentUnitID)
      {
         $objCollection->ExtentUnit = New ExtentUnit($objCollection->ExtentUnitID);
         $objCollection->ExtentUnit->dbLoad();
      }
      else
      {
         $objCollection->ExtentUnit = New ExtentUnit($objCollection->ExtentUnitID);
      }
	  
	  $detailExtent = ($objCollection->Extent) ? preg_replace('/\.(\d)0/', ".$1", $objCollection->getString('Extent')) . " " . $objCollection->getString('ExtentUnit') : "";
	  $detailExtent .= ($objCollection->AltExtentStatement) ? "; ".$objCollection->AltExtentStatement : "";
	  
	  $details .= " (" . $detailExtent . ")";
	  
	  echo($details);
	  
	  /*Add the abstract or the first 50 words of the scope note*/
	  if($objCollection->Abstract){
		  $collTeaser=$objCollection->Abstract;
	  } else {
		if($objCollection->Scope){
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
		}
	  }
	  
	  if($collTeaser) {
		  echo("<p class='collDetail'>". $collTeaser ."</p>");
	  }
	  
	  
/* end code to add details to list display */

} else {
	echo($objCollection->toString(LINK_TOTAL, true, false));
}

echo("</div>\n");
?>