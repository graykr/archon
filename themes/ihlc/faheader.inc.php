<?php
/**
 * Header file for default theme finding aid output
 *
 * @package Archon
 * @author Chris Rishel, Chris Prom, Kyle Fox
 */
isset($_ARCHON) or die();

// *** This is now a configuration directive. Please set in the Configuration Manager ***
//$_ARCHON->PublicInterface->EscapeXML = false;



if(!empty($objCollection->Subjects))
{
   $GenreSubjectTypeID = $_ARCHON->getSubjectTypeIDFromString('Genre/Form of Material');

   foreach($objCollection->Subjects as $objSubject)
   {
      if($objSubject->SubjectTypeID == $GenreSubjectTypeID)
      {
         $arrGenres[$objSubject->ID] = $objSubject;
      }
      else
      {
         $arrSubjects[$objSubject->ID] = $objSubject;
      }
   }
}

$_ARCHON->PublicInterface->Header->OnLoad .= "externalLinks(); \n";

if($_ARCHON->Error)
{
   $_ARCHON->PublicInterface->Header->OnLoad = "alert('" . encode(str_replace(';', "\n", $_ARCHON->processPhrase($_ARCHON->Error)), ENCODE_JAVASCRIPT) . "');";
}

if(defined('PACKAGE_COLLECTIONS'))
{
   if($objCollection->Repository)
   {
      $RepositoryName = $objCollection->Repository;
   }
   elseif($objDigitalContent->Collection->Repository)
   {
      $RepositoryName = $objDigitalContent->Collection->Repository;
   }
   else
   {
      $RepositoryName = $_ARCHON->Repository ? $_ARCHON->Repository->getString('Name') : '';
   }
   $_ARCHON->PublicInterface->Title = $_ARCHON->PublicInterface->Title ? 'Finding Aid for ' . $_ARCHON->PublicInterface->Title . ' | ' . $RepositoryName : $RepositoryName;
}
else
{
   $_ARCHON->PublicInterface->Title = $_ARCHON->PublicInterface->Title ? $_ARCHON->PublicInterface->Title . ' - ' . 'Archon' : 'Archon';
}

//adds to breadcrumbs
$_ARCHON->PublicInterface->addNavigation('Manuscript Collections Database', 'index.php', true);
$_ARCHON->PublicInterface->addNavigation('IHLC', 'https://www.library.illinois.edu/ihx/', true);

header('Content-type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <meta name="og:site_name" content="Illinois History and Lincoln Collections Manuscript Collections Database"/>
	   <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?php echo(strip_tags($_ARCHON->PublicInterface->Title)); ?></title>
      <link rel="stylesheet" type="text/css" href="themes/<?php echo($_ARCHON->PublicInterface->Theme); ?>/style.css" />
      <link rel="stylesheet" type="text/css" href="<?php echo($_ARCHON->PublicInterface->ThemeJavascriptPath); ?>/cluetip/jquery.cluetip.css" />
      <link rel="icon" type="image/ico" href="<?php echo($_ARCHON->PublicInterface->ImagePath); ?>/favicon.ico"/>
      <!--[if IE]>
        <link rel="stylesheet" type="text/css" href="themes/<?php echo($_ARCHON->PublicInterface->Theme); ?>/ie.css" />
        <link rel="stylesheet" type="text/css" href="themes/<?php echo($_ARCHON->PublicInterface->ThemeJavascriptPath); ?>/cluetip/jquery.cluetip.ie.css" />
      <![endif]-->
<?php echo($_ARCHON->getJavascriptTags('jquery.min')); ?>
<?php echo($_ARCHON->getJavascriptTags('jquery-ui.custom.min')); ?>
<?php echo($_ARCHON->getJavascriptTags('jquery-expander')); ?>
      <script type="text/javascript" src="<?php echo($_ARCHON->PublicInterface->ThemeJavascriptPath); ?>/jquery.hoverIntent.js"></script>
      <script type="text/javascript" src="<?php echo($_ARCHON->PublicInterface->ThemeJavascriptPath); ?>/cluetip/jquery.cluetip.js"></script>
      
      <script type="text/javascript" src="<?php echo($_ARCHON->PublicInterface->ThemeJavascriptPath); ?>/jquery.scrollTo-min.js"></script>
<?php echo($_ARCHON->getJavascriptTags('archon')); ?>
      <script type="text/javascript">
         /* <![CDATA[ */
         imagePath = '<?php echo($_ARCHON->PublicInterface->ImagePath); ?>';
         $(document).ready(function() {            
            $('div.listitem:nth-child(even)').addClass('evenlistitem');
            $('div.listitem:last-child').addClass('lastlistitem');
            $('#locationtable tr:nth-child(odd)').addClass('oddtablerow');
            $('.expandable').expander({
               slicePoint:       1000,              // make expandable if over this x chars
               widow:            100,              // do not make expandable unless total length > slicePoint + widow
               expandPrefix:     '',         // text to come before the expand link
               expandText:         'READ MORE',  //text to use for expand link
               expandEffect:     'fadeIn',         // or slideDown
               expandSpeed:      700,              // in milliseconds
               collapseTimer:    0,                // milliseconds before auto collapse; default is 0 (don't re-collapse)
               userCollapseText: 'COLLAPSE TEXT'      // text for collapse link
            });
         });

         function js_highlighttoplink(selectedSpan)
         {
            $('.currentBrowseLink').toggleClass('browseLink').toggleClass('currentBrowseLink');
            $(selectedSpan).toggleClass('currentBrowseLink');
            $(selectedSpan).effect('highlight', {}, 400);
         }

         $(window).load(function() {<?php echo($_ARCHON->PublicInterface->Header->OnLoad); ?>});
         $(window).unload(function() {<?php echo($_ARCHON->PublicInterface->Header->OnUnload); ?>});
         /* ]]> */
      </script>
<?php
      if($_ARCHON->PublicInterface->Header->Message && $_ARCHON->PublicInterface->Header->Message != $_ARCHON->Error)
      {
         $message = $_ARCHON->PublicInterface->Header->Message;
      } ?>
   </head>
   <body>
<?php
      $_ARCHON->PublicInterface->outputGoogleAnalyticsCode();


      if($message)
      {
         echo("<div class='message'>" . encode($message, ENCODE_HTML) . "</div>\n");
      }
?>
      <div id='top'>
		<div id="headerbar">
			<div id="topnavblock">
      
      <a href='http://illinois.edu'>University of Illinois at Urbana-Champaign</a> > <a href='http://library.illinois.edu'>Library</a> > <a href='http://www.library.illinois.edu/ihx'>IHLC</a> > <a href="http://www.library.illinois.edu/ihx/archon/">Manuscript Collections Database</a>
      </div>
			<div id="researchblock">
<?php
                  if($_ARCHON->Security->isAuthenticated())
                  {
                     echo("<span class='bold'>Welcome, " . $_ARCHON->Security->Session->User->toString() . "</span><br/>");

                     $logoutURI = preg_replace('/(&|\\?)f=([\\w])*/', '', $_SERVER['REQUEST_URI']);
                     $Logout = (encoding_strpos($logoutURI, '?') !== false) ? '&amp;f=logout' : '?f=logout';
                     $strLogout = encode($logoutURI, ENCODE_HTML) . $Logout;
                     echo("<a href='$strLogout'>Logout</a>");
                  }
                  else
                  {
                     echo("<a href='#' onclick='$(window).scrollTo(\"#archoninfo\"); if($(\"#userlogin\").is(\":visible\")) $(\"#loginlink\").html(\"Log In (Registered Researchers or Staff)\"); else $(\"#loginlink\").html(\"Hide\"); $(\"#userlogin\").slideToggle(\"normal\"); $(\"#ArchonLoginField\").focus(); return false;'>Log In</a>");
                  }

                  if(!$_ARCHON->Security->userHasAdministrativeAccess())
                  {
                     $emailpage = defined('PACKAGE_COLLECTIONS') ? "collections/research" : "core/contact";

                     /*echo(" | <a href='?p={$emailpage}&amp;f=email&amp;referer=" . urlencode($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) . "'>Contact Us</a>");*/
					 
					 echo(" | <a href='mailto:ihlc@library.illinois.edu'>Contact Us</a>");

                     if($_ARCHON->Security->isAuthenticated())
                     {
                        echo(" | <a href='?p=core/account&amp;f=account'>My Account</a>");
                     }
                     /*if(defined('PACKAGE_COLLECTIONS'))
                     {
                        $_ARCHON->Security->Session->ResearchCart->getCart();
                        $EntryCount = $_ARCHON->Security->Session->ResearchCart->getCartCount();

                        echo(" | <a href='?p=collections/research&amp;f=cart&amp;referer=" . urlencode($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) . "'>View Cart (<span id='cartcount'>$EntryCount</span>)</a>");
                     }*/
                  }
?>
               </div>
		</div>
		
		<div id="headercenter">
			<div id="headertitleblock">
				<a href='http://www.library.illinois.edu/ihx/index.html'>Illinois History and Lincoln Collections</a> | <a href='./index.php'>Manuscript Collections</a>
			</div>
			<div id="searchwrapper">
            <!--<div id="logo"><a href="index.php" ><img src="<?php echo($_ARCHON->PublicInterface->ImagePath); ?>/logo.gif" alt="logo" /></a><br/>Archives</div> -->
            <div id="searchblock">
               <form action="index.php" accept-charset="UTF-8" method="get" onsubmit="if(!this.q.value) { alert('Please enter search terms.'); return false; } else { return true; }">
                  <div>
                     <input type="hidden" name="p" value="core/search" />
                     <label for='q'></label>
					 <input type="text" size="35" maxlength="150" name="q" id="q" value="<?php echo(encode($_ARCHON->QueryString, ENCODE_HTML)); ?>" tabindex="100" placeholder="Search collection summaries"/>
                     <input type="submit" value="Find" tabindex="300" class='button' title="Search" /> 
					 
<?php
      if(defined('PACKAGE_COLLECTIONS') && CONFIG_COLLECTIONS_SEARCH_BOX_LISTS)
      {
?>
                     <input type="hidden" name="content" value="1" />
                     <?php
                  }
                     ?>
                  </div></form></div>
				  
				<div id="pdfsearchlink"><a class='bold' style='color:white' href='?p=core/index'>Return to main search page</a></div>
         </div>
		</div>
		
		<div id="headernav">
			<?php
                  $arrP = explode('/', $_REQUEST['p']);
                  $TitleClass = $arrP[0] == 'collections' && $arrP[1] != 'classifications' ? 'currentBrowseLink' : 'browseLink';
                  $ClassificationsClass = $arrP[1] == 'classifications' ? 'currentBrowseLink' : 'browseLink';
                  $SubjectsClass = $arrP[0] == 'subjects' ? 'currentBrowseLink' : 'browseLink';
                  $CreatorsClass = $arrP[0] == 'creators' ? 'currentBrowseLink' : 'browseLink';
                  $DigitalLibraryClass = $arrP[0] == 'digitallibrary' ? 'currentBrowseLink' : 'browseLink';
            ?>
                  <div id="browsebyblock">
            
					 <span id="browsebyspan">
                        Browse by:
                     </span>
					 
                     <span class="<?php echo($TitleClass); ?>">
                        <a href="?p=collections/collections" onclick="js_highlighttoplink(this.parentNode); return true;">Collection Titles</a>
                     </span>

                     <span class="<?php echo($SubjectsClass); ?>">
                        <a href="?p=subjects/subjects" onclick="js_highlighttoplink(this.parentNode); return true;">Subjects</a>
                     </span>
					 
                     <span class="<?php echo($CreatorsClass); ?>">
                        <a href="?p=creators/creators" onclick="js_highlighttoplink(this.parentNode); return true;">Persons or Organizations</a>
                     </span>
					 
                     <!--<span class="<?php echo($DigitalLibraryClass); ?>">
                        <a href="?p=digitallibrary/digitallibrary" onclick="js_highlighttoplink(this.parentNode); return true;">Images</a>
                     </span> -->

                  </div>
		</div>
 
    </div>


               <div id="breadcrumbblock">
<?php echo($_ARCHON->PublicInterface->createNavigation()); ?>
               </div>
               <div id="breadcrumbclearblock">.</div>

               <script type="text/javascript">
                  /* <![CDATA[ */
                  if ($.browser.msie && parseInt($.browser.version, 10) <= 8){
                     $.getScript('packages/core/js/jquery.corner.js', function(){
                        $("#searchblock").corner("5px");
                        $("#browsebyblock").corner("tl 10px");

                        $(function(){
                           $(".bground").corner("20px");
                           $(".mdround").corner("10px");
                           $(".smround").corner("5px");
                           $("#dlsearchblock").corner("bottom 10px");
                        });
                     });
                  }
                  /* ]]> */
               </script>         

               <!-- Begin Navigation Bar for Finding Aid View -->

               <div id='left'>
                  <div id='fanavbox'>
                     <p class='bold' style='text-align:center'><?php echo($objCollection->getString('Title')); ?></p>
                     <p><a href="#" tabindex="300">Overview</a></p>
<?php if($objCollection->Scope)
                  { ?><p><a href="#scopecontent" tabindex="400">Scope and Contents</a></p><?php } ?>
<?php
                  if($objCollection->PrimaryCreator->BiogHist)
                  {
?><p><a href="#bioghist" tabindex="500"><?php
                     if(trim($objCollection->PrimaryCreator->CreatorType) == "Corporate Name")
                     {
                        echo ("Historical Note");
                     }
                     elseif(trim($objCollection->PrimaryCreator->CreatorType) == "Family Name")
                     {
                        echo ("Family History");
                     }
                     else
                     {
                        echo ("Biographical Note");
                     }
?>
                  </a></p>
                  <?php
                  }
                  ?>
                  <?php if(!empty($arrSubjects))
                  { ?> <p><a href="#subjects" tabindex="600">Subject Terms</a></p><?php } ?>
            <?php if(!empty($objCollection->AccessRestrictions) || !empty($objCollection->UseRestrictions) || !empty($objCollection->PhysicalAccessNote) || !empty($objCollection->TechnicalAccessNote) || !empty($objCollection->AcquisitionSource) || !empty($objCollection->AcquisitionMethod) || !empty($objCollection->AppraisalInformation) || !empty($objCollection->CustodialHistory) || !empty($objCollection->OrigCopiesNote) || !empty($objCollection->OrigCopiesURL) || !empty($objCollection->RelatedMaterials) || !empty($objCollection->RelatedMaterialsURL) || !empty($objCollection->RelatedPublications) || !empty($objCollection->PreferredCitation) || !empty($objCollection->ProcessingInfo) || !empty($objCollection->RevisionHistory))
                  {
 ?> <p><a href="#admininfo" tabindex="700">Administrative Information</a></p> <?php } ?>
            <?php if(!empty($objCollection->Content))
                  {
 ?> <p><a href="#boxfolder" tabindex="800">Detailed Description</a></p><?php
                  }

                  foreach($objCollection->Content as $ID => $objContent)
                  {
                     if(!$objContent->ParentID && trim($objContent->Title))
                     {
                        echo("<p class='faitemcontent'><a href='?p=collections/findingaid&amp;id=$objCollection->ID&amp;q=$_ARCHON->QueryStringURL&amp;rootcontentid=$ID#id$ID'>" . $objContent->getString('Title') . "</a></p>\n");
                     }
                     else if(!$objContent->ParentID)
                     {
                        $LevelContainerString = $objContent->LevelContainer ? $objContent->LevelContainer->getString('LevelContainer') : '';
                        echo("<p class='faitemcontent'><a href='?p=collections/findingaid&amp;id=$objCollection->ID&amp;q=$_ARCHON->QueryStringURL&amp;rootcontentid=$ID#id$ID'>{$LevelContainerString} " . formatNumber($objContent->LevelContainerIdentifier) . "</a></p>\n");
                     }
                  }
            ?>
                  <form action="index.php" accept-charset="UTF-8" method="get" onsubmit="if(!this.q.value) { alert('Please enter search terms.'); return false; } else { return true; }">
                     <div id="fasearchblock">
                        <input type="hidden" name="p" value="core/search" />
                        <input type="hidden" name="flags" value="<?php echo(SEARCH_COLLECTIONCONTENT); ?>" />
                        <input type="hidden" name="collectionid" value="<?php echo($objCollection->ID); ?>" />
                        <input type="hidden" name="content" value="1" />
                        <label for='q'></label><input type="text" size="20" maxlength="150" name="q" id="q" value="<?php echo(encode($_ARCHON->QueryString, ENCODE_HTML)); ?>" tabindex="100" /><br/>
                        <input type="submit" value="Search This Finding Aid" tabindex="200" class='button' title="Search Box List" />
                     </div>
                  </form>
<?php
                  if(defined('PACKAGE_RESEARCH'))
                  {
                     echo("<hr/><p class='center' style='font-weight:bold'><a href='?p=research/research&amp;f=email&amp;referer=" . urlencode($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) . "'>Contact us about this collection</a></p>");
                  }
?>

         </div>
      </div>
      <script type="text/javascript">
         /* <![CDATA[ */
         if ($.browser.msie && parseInt($.browser.version, 10) <= 8){
            $('#searchblock').corner({
               tl: { radius: 5 },
               tr: { radius: 5 },
               bl: { radius: 5 },
               br: { radius: 5 },
               autoPad: true
            });
            $('#browsebyblock').corner({
               tl: { radius: 10 },
               tr: { radius: 0 },
               bl: { radius: 0 },
               br: { radius: 0 },
               autoPad: true
            });
            $('#left').corner({
               tl: { radius: 10 },
               tr: { radius: 10 },
               bl: { radius: 10 },
               br: { radius: 10 },
               autoPad: true
            });
         }
         /* ]]> */
      </script>
      <div id="famain">