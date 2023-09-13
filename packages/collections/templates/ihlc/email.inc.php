<?php
/**
 * ResearchEmail template
 *
 *
 * The Archon API is available through the variable:
 *
 *  $_ARCHON
 *
 * Refer to the Archon class definition in lib/archon.inc.php
 * for available properties and methods.
 *
 * @package Archon
 * @author Kyle Fox
 */

isset($_ARCHON) or die();


echo("<h1 id='titleheader'>" . strip_tags($_ARCHON->PublicInterface->Title) . "</h1>\n");

if($_ARCHON->Repository->Email){
  echo('<div class="textcontainer bground box4" style="text-align:center;margin-bottom:5em;">');
  echo('<p>Questions? You can email us at</p><p><a href="mailto:');
  echo($_ARCHON->Repository->Email);
  echo('">');
  echo($_ARCHON->Repository->Email);
  echo('</a></p></div>');
}

    $_ARCHON->Security->Session->ResearchCart->getCart();
    if($_ARCHON->Security->Session->ResearchCart->getCartCount())
    {
?>
<br/><div class='listitemhead bold'><?php echo($strCartAppend); ?></div>
<?php
        research_displaycart();
    }
    

?>
