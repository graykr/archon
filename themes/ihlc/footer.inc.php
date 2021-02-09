<?php
/**
 * Footer file for default theme
 *
 * @package Archon
 * @author Chris Rishel
 */

isset($_ARCHON) or die();

if($_ARCHON->Script == 'packages/collections/pub/findingaid.php')
{
    require("fafooter.inc.php");
    return;
}

?>



</div>


<?php
if(defined('PACKAGE_COLLECTIONS'))
{
	if($_ARCHON->QueryString && $_ARCHON->Script == 'packages/core/pub/search.php')
   {
      //add search box for inventories
	  echo("
	  <div class='bground textcontainer box4 pdfsearch'>");
	  echo("<h2>PDF/Deep Search Option</h2>");
	  echo("
<p style='text-align:center'>For additional results, you can use Google to try searching box and folder lists (uploaded as PDF files) as well:</p>
<div style='text-align:center'>				
    <form name='form1' action='https://www.google.com/search' class='search'>
    <input type='hidden' name='hq' value='inurl:www.library.illinois.edu/ihx/inventories'>
	<input type='text' size='25' name='q' class='searchinput' style='border:solid 1px #ddd' placeholder='Search box and folder lists'>
	<input type='submit' value='Find' class='button'></form>
</div>
<p>You can also expand your search to archival collections held in units throughout the University of Illinois Library 
using the <a href='?f=searchmultiple'>multiple repository search page</a>.");
	echo("
</div>	");
   }
   
}
?>


<div id="bottom">
    <br/>
    <hr id="footerhr" />
    <div id="userbox" class="smround">
<?php
if($_ARCHON->Security->isAuthenticated())
{
    $logoutURI = preg_replace('/(&|\\?)f=([\\w])*/', '', $_SERVER['REQUEST_URI']);
    $Logout = (encoding_strpos($logoutURI, '?') !== false) ? '&amp;f=logout' : '?f=logout';
?>
        <div id="userinfo">
            You are logged in as <?php echo($_ARCHON->Security->Session->User->toString()); ?>.<br/>
<?php
if($_ARCHON->Security->userHasAdministrativeAccess())
{
    echo("<a href='http://apache-ns.library.illinois.edu/ihx/archon?p=admin' rel='external'>Admin</a>&nbsp;");
}
else
{
    echo ("<a href='?p=core/account'>My Account</a>");

}
?>
            <a href='<?php echo(encode($logoutURI, ENCODE_HTML) . $Logout); ?>'>Log Out</a>
			
<?php
	if($_ARCHON->Security->userHasAdministrativeAccess())
	{
		echo("<p><a href='?p=core/index&f=listall'>Generate list of all collections (admin)</a></p>");
		echo("<p><a href='?p=core/index&f=openidentifiers'>Find open collection identifiers (admin)</a></p>");
	}
?>
			
        </div>
<?php
}
else
{
?>

<div id="userlogincontrols">
 <a id="loginlink" href="index.php?p=admin/core/login&amp;go=" onclick="if($('#userlogin').is(':visible')) {this.innerHTML = 'Log In (Staff)';} else {this.innerHTML = 'Hide';} $('#userlogin').slideToggle('normal'); return false;">Log In (Staff)</a>
</div>
<div id="userlogin" class="mdround" style="display:none">&nbsp;
    <form action="<?php echo(encode($_SERVER['REQUEST_URI'], ENCODE_HTML)); ?>" accept-charset="UTF-8" method="post">
    <div class='loginpair'>
    	<div class='loginlabel'><label for="ArchonLoginField">Login/E-mail:</label></div>
      	<div class='logininput'><input id="ArchonLoginField" type="text" name="ArchonLogin" size="20" tabindex="400" /></div>
    </div>
    <div class='loginpair'>
      <div class='loginlabel'><label for="ArchonPasswordField">Password:</label></div>
      <div class='logininput'><input id="ArchonPasswordField" type="password" name="ArchonPassword" size="20" tabindex="500" /></div>
    </div>
      <div id='loginsubmit'>
	      <input type="submit" value="Log In" class="button" tabindex="700" />&nbsp;&nbsp;<label for="RememberMeField"><input id="RememberMeField" type="checkbox" name="RememberMe" value="1" tabindex="600" />Remember me</label>
	  </div>
      <div id='loginlink'>
        <a href="?p=core/register" tabindex="800">Register an Account</a>
      </div>
    </form>
</div>
<?php
}
?>
  </div>
<?php
if(defined('PACKAGE_COLLECTIONS'))
{
    echo("<div id='contactcontainer'>");

    if($_ARCHON->Repository->URL)
    {
        echo("<div id='repositorylink'><a href='{$_ARCHON->Repository->getString('URL')}'>{$_ARCHON->Repository->getString('Name')}</a></div>\n");
    }
    echo("<div id='emaillink'>Contact Us: <a href='mailto:ihlc@library.illinois.edu'>ihlc@library.illinois.edu</a></div>\n");
    echo("<div id='privacy'><p><a href='?p=core/index&f=privacy'>Privacy Policy</a></p></div>");
	echo("</div>");
}

?>
</div>
