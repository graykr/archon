<?php
/**
 * DigitalContent list template
 *
 * The variable:
 *
 *  $objDigitalContent
 *
 * is an instance of a DigitalContent object, with its properties
 * already loaded when this template is referenced.
 *
 * Refer to the DigitalContent class definition in lib/digitallibrary.inc.php
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

/*Note: It looks like the variable given this template is not "$objDigitalContent" as noted above but instead $item,
 which is the linked string of the digital content and $date, which is its date with a leading comma.*/

echo($item);

if($date)
{
	echo(" (");
	$date = trim(str_replace(',', '', $date)); //remove the leading comma and space
	echo($date);
	echo(")");
}

echo("</div>\n");
?>