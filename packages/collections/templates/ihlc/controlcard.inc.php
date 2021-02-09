<?php
/**
 * Control Card template for "default" templateset
 *
 * The variable:
 *
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
 * @author Chris Rishel, Chris Prom, Paul Sorensen
 */
isset($_ARCHON) or die();

$repositoryid = $objCollection->RepositoryID;


//notice
if($_ARCHON->config->AlertNoticeIHLC) {
 
 if(strtotime($_ARCHON->config->AlertNoticeEndDate)>time()) {
	 echo("<p style='border: 2px solid red; font-weight: bold; text-align: center; padding: 10px;'>");
	 echo($_ARCHON->config->AlertNoticeIHLC);
	 echo("</p>");
 }
}

echo("<h1 id='titleheader'>" . $_ARCHON->PublicInterface->Title . "</h1>\n");

/** Gather text to build a request link or other links to pre-filled forms **/

	$requestTitle = ($objCollection->Title) ? $objCollection->Title : "";
	$requestDates = ($objCollection->InclusiveDates) ? ", ".$objCollection->InclusiveDates : "";
	$requestTitle = urlencode($requestTitle . $requestDates);

	$requestIdentifier = ($objCollection->Classification) ? $objCollection->Classification->toString(LINK_NONE, true, false, true, false)."/".$objCollection->getString('CollectionIdentifier') : $objCollection->getString('CollectionIdentifier');

	$requestExtent = ($objCollection->Extent) ? preg_replace('/\.(\d)0/', ".$1", $objCollection->getString('Extent')) . " " . $objCollection->getString('ExtentUnit') : "";
	$requestExtent .= ($objCollection->AltExtentStatement) ? "; ".$objCollection->AltExtentStatement : "";

/*For reading room request link */
if($_ARCHON->config->AddRequestLink and $_ARCHON->config->RequestURL) 
{
	$requestBaseLink =	$_ARCHON->config->RequestURL;//defined in config file

	//concatenate the field names (URL parameters) and metadata from the collection to form the request link
	$requestLink = $requestBaseLink;
	if($_ARCHON->config->RequestVarTitle){
		$requestLink .= $_ARCHON->config->RequestVarTitle . $requestTitle;
	}
	if($_ARCHON->config->RequestVarIdentifier) {
		$requestLink .= $_ARCHON->config->RequestVarIdentifier . $requestIdentifier;
	}
	if($_ARCHON->config->RequestVarDates) {
		$requestLink .= $_ARCHON->config->RequestVarDates;
		$requestLink .= ($objCollection->InclusiveDates) ? $objCollection->InclusiveDates : "";
	}
	if($_ARCHON->config->RequestVarExtent) {
		$requestLink .= $_ARCHON->config->RequestVarExtent . $requestExtent;
	}
	
	//location can be defined as a full string here, if defined in the config file, or added later (not yet coded)
	if($_ARCHON->config->RequestHasConsistentLocation) {
		if($_ARCHON->config->RequestVarLocation and $_ARCHON->config->RequestDefaultLocation){
			$requestLink .= $_ARCHON->config->RequestVarLocation . $_ARCHON->config->RequestDefaultLocation;
		}
	}
	
	//for these variables, the values are defined in the config file (they will be the same for all collections)
	if($_ARCHON->config->RequestStringBox) {
		$requestLink .= $_ARCHON->config->RequestStringBox;
	}
	if($_ARCHON->config->RequestStringFolderNo){
		$requestLink .= $_ARCHON->config->RequestStringFolderNo;
	}
	if($_ARCHON->config->RequestStringFolderTitle) {
		$requestLink .= $_ARCHON->config->RequestStringFolderTitle;
	}
}
/** End section for preparation of the request link.*/

/** Get user name for recording work needed or completed **/

$requestUsername = ($_ARCHON->Security->isAuthenticated())? urlencode($_ARCHON->Security->Session->User->getString('DisplayName')) : "";

/** For referring collection with work needed **/
$requestBaseLink1 =	"https://docs.google.com/a/illinois.edu/forms/d/e/1FAIpQLSc-feKuMNYFWgczQ5e3vR8YX38Z6dc0KMpRqRRvTgopLf9L3w/viewform";
$requestVarTitle1 = "?entry.2031905867=";
$requestVarIdentifier1 = "&entry.171099272=";
$requestVarExtent1 = "&entry.1837024941=";
$requestVarUsername1 = "&entry.694225667=";

$requestLink1 = $requestBaseLink1 . $requestVarTitle1.$requestTitle . $requestVarIdentifier1.$requestIdentifier;
$requestLink1 .= $requestVarExtent1 . $requestExtent;
$requestLink1 .= $requestVarUsername1 . $requestUsername;

/** For photoduplication **/
$requestBaseLink2 =	"https://illinois.edu/fb/sec/485285";
$requestVarTitle2 = "?colltitle=";
$requestVarIdentifier2 = "&collid=";

$requestLink2 = $requestBaseLink2 . $requestVarTitle2.str_replace(" ","_",$requestTitle) . $requestVarIdentifier2.$requestIdentifier;

/** For submitting work completed **/

$requestBaseLink3 =	"https://docs.google.com/a/illinois.edu/forms/d/e/1FAIpQLSe6lT-tbq1yBMg-X48dQNrFnB-_Dj-K76984Vy9TGARbIZZmw/viewform";
$requestVarTitle3 = "?entry.2031905867=";
$requestVarIdentifier3 = "&entry.171099272=";
$requestVarExtent3 = "&entry.1837024941=";
$requestVarUsername3 = "&entry.694225667=";

$requestLink3 = $requestBaseLink3 . $requestVarTitle3.$requestTitle . $requestVarIdentifier3.$requestIdentifier;
$requestLink3 .= $requestVarExtent3 . $requestExtent;
$requestLink3 .= $requestVarUsername3 . $requestUsername;

/** For Digitization Services scanning request **/

$requestBaseLink4 ="https://docs.google.com/forms/d/e/1FAIpQLSc_CPSt0urJaJJBU8qsE2284n72ZWl7u0cpbPl_yWbBC0NTLA/viewform";
$requestVarRepository4 ="?entry.1045941438=Illinois%20History%20and%20Lincoln%20Collections";
$requestVarTitle4="&entry.594578941=";
$requestVarIdentifier4="&entry.121951458=IHLC%20MS%20";

$requestLink4 = $requestBaseLink4 . $requestVarRepository4 . $requestVarTitle4.$requestTitle . $requestVarIdentifier4.$requestIdentifier;

?>

<div id='ccardleft'>        <!--begin div ccardleft -->
   <div id="ccardpublic" class='mdround'>  <!-- begin div ccardcontents -->
      <?php
      if($objCollection->Title)
      {
         ?>
         <div class='ccardcontent'><span class='ccardlabel'>Title:</span> <?php echo($objCollection->toString()); ?></div>
         <?php
      }

      if($objCollection->Classification)
      {
         ?>
         <div class='ccardcontent'><span class='ccardlabel'>ID:</span> <?php echo($objCollection->Classification->toString(LINK_NONE, true, false, true, false)); ?>/<?php echo($objCollection->getString('CollectionIdentifier')); ?></div>
         <?php
      }
		
		
				
		if($objCollection->CollectionIdentifier) {
			echo("<div class='ccardcontent'><span class='ccardlabel'>Collection identifier: </span>");
			echo($objCollection->getString('CollectionIdentifier'));
			echo("</div>");
		}
	
		
      if($objCollection->Extent)
      {
         ?>
         <div class='ccardcontent'><span class='ccardlabel'>Extent:</span> <?php echo(preg_replace('/\.(\d)0/', ".$1", $objCollection->getString('Extent'))) . " " . $objCollection->getString('ExtentUnit'); ?>
         </div>
   <?php
}

if($objCollection->AltExtentStatement)
{
   ?>

         <div class='ccardcontent'><span class='ccardlabel'><a href='#' onclick="toggleDisplay('CollectionAltExtent'); return false;"><img id='CollectionAltExtentImage' src='<?php echo($_ARCHON->PublicInterface->ImagePath); ?>/plus.gif' alt='expand icon' />
   <?php
   echo ("More Extent Information");
   ?>
               </a></span>
            <div class='ccardshowlist' style='display:none' id='CollectionAltExtentResults'>
   <?php echo($objCollection->AltExtentStatement); ?>
            </div>
         </div>
   <?php
}

if($objCollection->PredominantDates)
{
   ?>
         <div class='ccardcontent'><span class='ccardlabel'>Predominant Dates:</span> <?php echo($objCollection->PredominantDates); ?></div>
         <?php
      }

      if($objCollection->Arrangement)
      {
         ?>

         <div class='ccardcontent'><span class='ccardlabel'><a href='#' onclick="toggleDisplay('CollectionArrangement'); return false;"><img id='CollectionArrangementImage' src='<?php echo($_ARCHON->PublicInterface->ImagePath); ?>/plus.gif' alt='expand icon' />
   <?php
   echo ("Arrangement");
   ?>
               </a></span>
            <div class='ccardshowlist' style='display:none' id='CollectionArrangementResults'>
   <?php echo($objCollection->getString('Arrangement')); ?>
            </div>
         </div>
   <?php
}

if($objCollection->Abstract)
{
   ?>

         <div class='ccardcontent'><span class='ccardlabel'><a href='#' onclick="toggleDisplay('CollectionAbstract'); return false;"><img id='CollectionAbstractImage' src='<?php echo($_ARCHON->PublicInterface->ImagePath); ?>/plus.gif' alt='expand icon' />
   <?php
   echo ("Abstract");
   ?>
               </a></span>
            <div class='ccardshowlist' style='display:none' id='CollectionAbstractResults'>
   <?php echo($objCollection->getString('Abstract')); ?>
            </div>
         </div>
   <?php
}

if(!empty($objCollection->Creators))
{
   ?>

         <div class='ccardcontent'><span class='ccardlabel'><a href='#' onclick="toggleDisplay('CollectionCreators'); return false;"><img id='CollectionCreatorsImage' src='<?php echo($_ARCHON->PublicInterface->ImagePath); ?>/plus.gif' alt='expand icon' />

   <?php
   echo ("Creators");
   ?>
               </a></span>
            <div class='ccardshowlist' style='display:none' id='CollectionCreatorsResults'>
   <?php echo($_ARCHON->createStringFromCreatorArray($objCollection->Creators, '<br/>', LINK_TOTAL, TRUE)); ?>
            </div>
         </div>
   <?php
}

if($objCollection->BiogHist)
{
   ?>

         <div class='ccardcontent'><span class='ccardlabel'><a href='#' onclick="toggleDisplay('CollectionBiogHist'); return false;"><img id='CollectionBiogHistImage' src='<?php echo($_ARCHON->PublicInterface->ImagePath); ?>/plus.gif' alt='expand icon' />
   <?php
   echo ("Administrative/Biographical History");
   ?>
               </a></span>
            <div class='ccardshowlist' style='display:none' id='CollectionBiogHistResults'>
   <?php
   echo($objCollection->getString('BiogHist'));
   if($objCollection->BiogHistAuthor)
   {
      echo(" <span class='bold'>Author:</span> " . $objCollection->getString('BiogHistAuthor'));
   }
   ?>
            </div>
         </div>
   <?php
}


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

   if(!empty($arrSubjects))
   {
      ?>
            <div class='ccardcontent'><span class='ccardlabel'><a href='#' onclick="toggleDisplay('subjects'); return false;"><img id='subjectsImage' src='<?php echo($_ARCHON->PublicInterface->ImagePath); ?>/plus.gif' alt='expand icon' /> Subjects</a> <span style='font-size:80%'>(links to similar collections)</span></span><br/>
               <div class='ccardshowlist' style='display: none' id='subjectsResults'><?php echo($_ARCHON->createStringFromSubjectArray($arrSubjects, "<br/>\n", LINK_TOTAL)); ?></div>
            </div>
      <?php
   }
   if(!empty($arrGenres))
   {
      ?>
            <div class='ccardcontent'><span class='ccardlabel'><a href='#' onclick="toggleDisplay('genres'); return false;"><img id='genresImage' src='<?php echo($_ARCHON->PublicInterface->ImagePath); ?>/plus.gif' alt='expand icon' /> Forms of Material</a> <span style='font-size:80%'>(links to similar genres)</span></span><br/>
               <div class='ccardshowlist' style='display: none' id='genresResults'><?php echo($_ARCHON->createStringFromSubjectArray($arrGenres, "<br/>\n", LINK_TOTAL)); ?></div>
            </div>
      <?php
   }
}

if(!empty($objCollection->Languages))
{
   ?>
         <div class='ccardcontent'><span class='ccardlabel'><a href='#' onclick="toggleDisplay('langs'); return false;"><img id='langsImage' src='<?php echo($_ARCHON->PublicInterface->ImagePath); ?>/plus.gif' alt='expand icon' /> Languages of Materials</a></span><br/>
            <div class='ccardshowlist' style='display: none' id='langsResults'><?php echo($_ARCHON->createStringFromLanguageArray($objCollection->Languages, "<br/>\n", LINK_TOTAL)); ?></div>
         </div>
   <?php
}

//changed to add related info section
if(!empty($objCollection->OrigCopiesNote) || !empty($objCollection->OrigCopiesURL) || !empty($objCollection->RelatedMaterials) || !empty($objCollection->RelatedMaterialsURL) || !empty($objCollection->RelatedPublications)) {
?>

<div class='ccardcontent'><span class='ccardlabel'><a href='#' onclick="toggleDisplay('relatedinformation'); return false;"><img id='relatedinformationImage' src='<?php echo($_ARCHON->PublicInterface->ImagePath); ?>/plus.gif' alt='expand icon' /> Additional sources</a></span><br/>
            <div class='ccardshowlist' style='display:none' id='relatedinformationResults'>
<?php
				if($objCollection->OrigCopiesNote || $objCollection->OrigCopiesURL)
               {
                  ?>
                  <div class='ccardcontent'><span class='ccardlabel'>Other Formats:</span>
                  <?php
                  if($objCollection->OrigCopiesNote)
                  {
                     echo($objCollection->getString('OrigCopiesNote'));
                  }
                  if($objCollection->OrigCopiesURL)
                  {
                     echo("<br/>For more information please see <a href='{$objCollection->getString('OrigCopiesURL')}'>{$objCollection->getString('OrigCopiesURL')}</a>.");
                  }
                  ?>
                  </div>
                     <?php
                  }

                  if($objCollection->RelatedMaterials || $objCollection->RelatedMaterialsURL)
                  {
                     ?>
                  <div class='ccardcontent'><span class='ccardlabel'>Related Materials:</span>
                  <?php
                  if($objCollection->RelatedMaterials)
                  {
                     echo($objCollection->getString('RelatedMaterials'));
                  }
                  if($objCollection->RelatedMaterialsURL)
                  {
                     echo("<br/>For more information please see <a href='{$objCollection->getString('RelatedMaterialsURL')}'>{$objCollection->getString('RelatedMaterialsURL')}</a>.");
                  }
                  ?>
                  </div>
                     <?php
                  }


                  if($objCollection->RelatedPublications)
                  {
                     ?>
                  <div class='ccardcontent'><span class='ccardlabel'>Related Publications:</span> <?php echo($objCollection->getString('RelatedPublications')); ?></div>
                  <?php
               }
	echo("</div>");  
	echo("</div>");// ending relatedinfo content

}

if(!empty($objCollection->AcquisitionDate) || !empty($objCollection->AccrualInfo) || !empty($objCollection->AccessRestrictions) || !empty($objCollection->UseRestrictions) || !empty($objCollection->PhysicalAccessNote) || !empty($objCollection->TechnicalAccessNote) || !empty($objCollection->AcquisitionSource) || !empty($objCollection->AcquisitionMethod) || !empty($objCollection->AppraisalInformation) || !empty($objCollection->PreferredCitation) || !empty($objCollection->ProcessingInfo) || !empty($objCollection->RevisionHistory) || !empty($objCollection->MaterialType))
//admin info exists
{
   ?>

         <div <?php 
		// hide admin info from users not logged in
		if(!$_ARCHON->Security->isAuthenticated()) { 
			echo("style='display:none;'");
		}
		?> 
		class='ccardcontent'><span class='ccardlabel'><a href='#' onclick="toggleDisplay('otherinformation'); return false;"><img id='otherinformationImage' src='<?php echo($_ARCHON->PublicInterface->ImagePath); ?>/plus.gif' alt='expand icon' /> Administrative Information</a></span><br/>
            <div class='ccardshowlist' style='display:none' id='otherinformationResults'>

   <?php
			   if(!empty($objCollection->Repository) && ($objCollection->Repository != $_ARCHON->Repository))
			   {
				  ?>
							  <div class='ccardcontent'><span class='ccardlabel'>Repository:</span> <?php echo$objCollection->Repository->getString('Name'); ?></div>
							  <?php
				}

               if($objCollection->AcquisitionDate || $objCollection->AccrualInfo)
               {
                  ?>
                  <div class='ccardcontent'><span class='ccardlabel'>Acquired:</span>
                  <?php
                  if($objCollection->AcquisitionDate)
                  {

                     if($objCollection->AcquisitionDateMonth <> "00")
                     {
                        echo($objCollection->AcquisitionDateMonth . '/');
                     }
                     if($objCollection->AcquisitionDateDay <> "00")
                     {
                        echo($objCollection->AcquisitionDateDay . '/');
                     }
                     echo ($objCollection->AcquisitionDateYear . ".  ");
                  }
                  if($objCollection->AccrualInfo)
                  {
                     echo($objCollection->getString('AccrualInfo'));
                  }
                  ?>
                  </div>
                     <?php
                  }



                  if($objCollection->AccessRestrictions)
                  {
                     ?>
                  <div class='ccardcontent'><span class='ccardlabel'>Restrictions:</span> <?php echo($objCollection->getString('AccessRestrictions')); ?></div>
                  <?php
               }

               if($objCollection->UseRestrictions)
               {
                  ?>
                  <div class='ccardcontent'><span class='ccardlabel'>Rights:</span> <?php echo($objCollection->getString('UseRestrictions')); ?></div>
                  <?php
               }

               if($objCollection->PhysicalAccess)
               {
                  ?>
                  <div class='ccardcontent'><span class='ccardlabel'>Access Notes: </span><?php echo($objCollection->getString('PhysicalAccess')); ?></div>
                  <?php
               }

               if($objCollection->TechnicalAccess)
               {
                  ?>
                  <div class='ccardcontent'><span class='ccardlabel'>Technical Notes: </span><?php echo($objCollection->getString('TechnicalAccess')); ?></div>

                  <?php
               }

               if($objCollection->AcquisitionSource || $objCollection->AcquisitionMethod)
               {
                  ?>
                  <div class='ccardcontent'><span class='ccardlabel'>Acquisition Note: </span>
                  <?php
                  if($objCollection->AcquisitionSource)
                  {
                     echo("&nbsp;<em>Source:</em> " . $objCollection->getString('AcquisitionSource') . ".<br/>");
                  }
                  if($objCollection->AcquisitionMethod)
                  {
                     echo($objCollection->getString('AcquisitionMethod'));
                  }
                  ?>
                  </div>
                     <?php
                  }

                  if($objCollection->AppraisalInformation)
                  {
                     ?>
                  <div class='ccardcontent'><span class='ccardlabel'>Appraisal Notes:</span> <?php echo($objCollection->getString('AppraisalInformation')); ?></div>
                  <?php
               }

               


               if($objCollection->PreferredCitation)
               {
                  ?>
                  <div class='ccardcontent'><span class='ccardlabel'>Preferred Citation:</span> <?php echo($objCollection->getString('PreferredCitation')); ?></div>
                  <?php
               }

               if($objCollection->ProcessingInformation)
               {
                  ?>
                  <div class='ccardcontent'><span class='ccardlabel'>Processing Note</span>: <?php echo($objCollection->getString('ProcessingInformation')); ?></div>
                  <?php
               }


               if($objCollection->RevisionHistory)
               {
                  ?>
                  <div class='ccardcontent'><span class='ccardlabel'>Finding Aid Revisions:</span> <?php echo($objCollection->getString('RevisionHistory')); ?></div>
                  <?php
               }

               if($objCollection->MaterialType)
               {
                  ?>
                  <div class='ccardcontent'><span class='ccardlabel'>Collection Material Type:</span> <?php echo($objCollection->MaterialType->toString()); ?></div>
                  <?php
               }


               




               echo("</div>");  // ending ccardshowlist
               echo("</div>");   // ending admininfo content
            }

            if(!empty($arrDisplayAccessions))
            {
               ?>
               <div class='ccardcontent'><span class='ccardlabel'><a href='#' onclick="toggleDisplay('accessions'); return false;"><img id='accessionsImage' src='<?php echo($_ARCHON->PublicInterface->ImagePath); ?>/plus.gif' alt='expand icon' /> Unprocessed Materials<?php
            if($_ARCHON->Security->verifyPermissions(MODULE_COLLECTIONS, READ))
            {
               echo (" and Processed Accessions");
            }
               ?></a></span><br/>

                        <?php
                        echo ("<div class='ccardshowlist' style='display: none' id='accessionsResults'>");

                        foreach($arrDisplayAccessions as $objAccession)
                        {
                           echo($objAccession->toString(LINK_EACH) . "<br/>\n");
                           $ResultCount++;
                        }
                        ?>

               </div>
            </div>
                  <?php
               }

               if($objCollection->Books)
               {
                  ?>
            <div class='ccardcontent'><span class='bold'><a href='#' onclick="toggleDisplay('LinkedBooks'); return false;"><img id='LinkedBooksImage' src='<?php echo($_ARCHON->PublicInterface->ImagePath); ?>/plus.gif' alt='expand icon' /> Books </a></span><br/>
               <div class='ccardshowlist' style='display: none' id='LinkedBooksResults'><?php echo($_ARCHON->createStringFromBookArray($objCollection->Books, "<br/>\n", LINK_TOTAL)); ?></div>
            </div>

<?php
            }




            echo("</div>");	//end ccardpublic



/*Staff information card at left */
         if($_ARCHON->Security->verifyPermissions(MODULE_COLLECTIONS, READ))
         {
         ?>
         <div id='ccardstaff' class='mdround'>
            <div class='ccardstafflabel'>Staff Information</div>
            <div class='ccardcontents'><br/>
				<?php 
				echo("<span class='ccardlabel'>Archon access: </span>");
				if($objCollection->Enabled)
				{
					$accessible = $objCollection->getString('Enabled');
					if($accessible == 1)
					{
						echo("Published");
					} else {
						echo("Unpublished");
					}
				} else {
					echo("Unpublished");
				}
				echo("<br /><br />");
				
				echo("<span class='ccardlabel'>Storage Locations: </span>");
				if(!empty($objCollection->LocationEntries)) {
					echo("Please see table at right for storage locations.");
				} else {
					echo("No locations are listed for this collection.");
				}
				/*
				?>
				
               <span class='ccardlabel'>Storage Locations:</span>
   <?php
   if(!empty($objCollection->LocationEntries))
   {
      
	  ?>
                  <table id='locationtable' border='1'>
                     <tr>
                        <th>Content</th>
                        <th>Location</th>
                        <th>Range</th>
                        <th>Section</th>
                        <th>Shelf</th>
                        <th>Extent</th>
                     </tr>
                     <tr>
                        <td>
      <?php echo($_ARCHON->createStringFromLocationEntryArray($objCollection->LocationEntries, '&nbsp;</td></tr><tr><td>', LINK_EACH, false, '&nbsp;</td><td>')); ?>
                        </td>
                     </tr>
                  </table>
      <?php
	  
      ?>
                  Please see table at right for storage locations.
      <?php
   }
   else
   {
      ?>
                  No locations are listed for this record series.
      <?php
   }
   */
   ?>
            </div>

            <div class="ccardcontents"><br/><span class='ccardlabel'>Show this record as:</span><br/><br/>
               <a href='?p=collections/ead&amp;id=<?php echo($objCollection->ID); ?>&amp;templateset=ead&amp;disabletheme=1&amp;output=<?php echo(formatFileName($objCollection->getString('SortTitle', 0, false, false))); ?>'>EAD</a><br/>
               <a href='?p=collections/marc&amp;id=<?php echo($objCollection->ID); ?>'>MARC</a><br/>
               <a href='?p=collections/controlcard&amp;id=<?php echo($objCollection->ID); ?>&amp;templateset=kardexcontrolcard&amp;disabletheme=1'>5 by 8 Kardex</a><br/>
               <a href='?p=collections/controlcard&amp;id=<?php echo($objCollection->ID); ?>&amp;templateset=draftcontrolcard&amp;disabletheme=1'>Review copy/draft</a><br/>
			   <a href="?p=collections/controlcard&amp;id=<?php echo($objCollection->ID); ?>">Current view without highlights</a>
            </div>
			<div class="form-links">
				<p>
				<a href='<?php echo($requestLink2);?>' target='_blank'>Generate photoduplication request</a><br/>
				<a href='<?php echo($requestLink1);?>' target='_blank'>Record additional work needed</a><br/> 
				<a href='<?php echo($requestLink3);?>' target='_blank'>Submit work completed</a>
				</p>
				<p>
				<a href='<?php echo($requestLink4);?>' target='_blank'>Generate Digitization Services scanning request</a>
				</p>
			</div>
         </div>

   <?php
}

echo("</div>"); //end ccardleft



echo ("<div id='ccardprintcontact' class='smround'> ");

//add request button
if($requestLink) {
	echo("<a href='" . $requestLink . "' target='_blank'><img src='" . $_ARCHON->PublicInterface->ImagePath . "/box.png' alt='Request' style='padding-right:2px'/></a><a href='" . $requestLink . "' target='_blank'>");
	if($_ARCHON->config->RequestLinkText) {
		echo($_ARCHON->config->RequestLinkText);
	} else {
		echo("Submit request");
	}
	echo("</a>");

	echo(" | ");
}
//end section with the request button

echo("<span class='print-friendly-link'><a href='?p=collections/controlcard&amp;id=" . $objCollection->ID . "&amp;templateset=print&amp;disabletheme=1'><img src='" . $_ARCHON->PublicInterface->ImagePath . "/printer.png' alt='Printer-friendly' /></a> <a href='?p=collections/controlcard&amp;id=" . $objCollection->ID . "&amp;templateset=print&amp;disabletheme=1'>Printer-friendly</a>");


echo(" | </span>");

$emailsubject="Inquiry: IHLC Manuscript Collection";

if($objCollection->CollectionIdentifier) {
	$emailsubject .= " (ID ".$objCollection->getString('CollectionIdentifier').")";
}
echo("<a href='mailto:ihlc@library.illinois.edu?subject=". $emailsubject ."'><img src='" . $_ARCHON->PublicInterface->ImagePath . "/email.png' alt='Email Us' /> </a><a href='mailto:ihlc@library.illinois.edu?subject=". $emailsubject ."'>Email Us</a>");

echo("</div>");

/* Link to email form (replaced above because the form is not sending email): 
<a href='?p=collections/research&amp;f=email&amp;repositoryid=$repositoryid&amp;referer=" . urlencode($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) . "'>
*/


echo("<div id='ccardright'>        <!--begin div ccardright -->");
if($objCollection->Scope || !empty($objCollection->Content) || ($objCollection->DigitalContent || $containsImages) || !empty($objCollection->OtherURL) || !empty($objCollection->OtherNote))
{
   ?>
         <div id="ccardscope" class="mdround">
         <?php
         if($objCollection->Scope)
         {
            $scopedraft=substr(strip_tags($objCollection->getString('Scope')),0,7);
			if($scopedraft==="[DRAFT]") {
				if($_ARCHON->Security->userHasAdministrativeAccess()) {
					echo("<span style='color:red;font-weight:bold'>** Draft mode: Description below is only visible to staff **</span>");
					echo("<div class='ccardcontent expandable' style='padding-left:.2em'><span class='ccardlabel'>Scope and Contents:</span>");
					echo($objCollection->getString('Scope')); 
					echo("</div>");
				} else {
					echo("<div class='ccardcontent'><span class='ccardlabel'>Descriptive note:</span> This collection is currently unprocessed. <p>Please contact the Illinois History and Lincoln Collections at <a href='mailto:ihlc@library.illinois.edu'>ihlc[at]library.illinois.edu</a> for more information about the contents of this collection and its processing status.</p></div>");
				}
			} else {
			?>
               <div class='ccardcontent expandable' style='padding-left:.2em'><span class='ccardlabel'>Scope and Contents:</span> 
			   <?php echo($objCollection->getString('Scope')); ?></div>
            <?php
			}
         }
         if($objCollection->DigitalContent || $containsImages)
         {
            ?>

               <div class='ccardcontent'><span class='ccardlabel'><a href='#' onclick="toggleDisplay('digitalcontent'); return false;"><img id='digitalcontentImage' src='<?php echo($_ARCHON->PublicInterface->ImagePath); ?>/plus.gif' alt='expand icon' /> On-line Images/Records</a></span><br/>
                  <div class='ccardshowlist' style="display: none;" id="digitalcontentResults">
               <?php
               if($containsImages)
               {
                  echo("<span class='bold'><a href='index.php?p=digitallibrary/thumbnails&amp;collectionid={$objCollection->ID}'>Images</a></span> (browse thumbnails)<br/>\n\n");
               }
               if($objCollection->DigitalContent)
               {
                  //previous code:
				  //echo("<br/><span class='bold'>Documents and Files:</span><br/>&nbsp;");
				  //echo($_ARCHON->createStringFromDigitalContentArray($objCollection->DigitalContent, "<br/>\n&nbsp;", LINK_TOTAL));
				  
				  echo("<span class='bold'>Documents and Files:</span>");
				  
				  $ihlcDigitalContentArray = $objCollection->DigitalContent;
				  $ihlcDigitalSortArray = array();
				  foreach($ihlcDigitalContentArray as $ihlcDigitalElement){
					$ihlcDigitalSortArray[$ihlcDigitalElement->ID]=$ihlcDigitalElement->Date;
				  }
				  //print_r($ihlcDigitalSortArray);
				  natsort($ihlcDigitalSortArray);
				  //print_r($ihlcDigitalSortArray);
				  
				  //modified version of createStringFromDigitalContentArray
				  if(empty($ihlcDigitalContentArray))
				  {
					 $_ARCHON->declareError("Could not create DigitalContent String: No IDs specified.");
					 echo("error");
				  } else {
					  
					  $ihlcString ="<ul>";
					  foreach($ihlcDigitalSortArray as $ihlcKey=>$ihlcValue)
					  {
						 //$ihlcDigitalContent
						 $ihlcString .= "<li>";
						 $ihlcString .= $ihlcDigitalContentArray[$ihlcKey]->toString(LINK_TOTAL, false);
						 if ($ihlcValue==""){
							$ihlcString .= ", undated";
						 } else {
							$ihlcString .= ", " . $ihlcValue;
						 }
						 $ihlcString .= "</li>";
						 
					  }
					  $ihlcString .= "</ul>";
					  echo($ihlcString); 
				  }
				  
				  if ($_ARCHON->Security->userHasAdministrativeAccess()) {
					echo("<span class='bold'>Documents and Files (sorted by title - visible only when logged in):</span>");
					$doRecordList = "<ul>";
					foreach($objCollection->DigitalContent as $doRecord) {
						$doRecordList .= "<li>";
						$doRecordList .= $doRecord->toString(LINK_TOTAL, false);
						if ($doRecord->Date){
							$doRecordList .= ", ". $doRecord->getString("Date");
						}
						$doRecordList .= "</li>";
					}
					$doRecordList .= "</ul>";
		
					echo($doRecordList);
				  }
               }
               ?>
                  </div>
               </div>
                     <?php
                  }


                  if(!empty($objCollection->Content))
                  {
                     ?>
               <div class='ccardcontent'><span class='ccardlabel'><a href='?p=collections/findingaid&amp;id=<?php echo($objCollection->ID); ?>&amp;q=<?php echo($_ARCHON->QueryStringURL); ?>'>Detailed Description</a></span><br/>
      <?php
      $DisableTheme = $_ARCHON->PublicInterface->DisableTheme;
      $_ARCHON->PublicInterface->DisableTheme = true;

      foreach($objCollection->Content as $ID => $objContent)
      {
         if(!$objContent->ParentID)
         {
            if($objContent->enabled())
            {
               echo("<span class='ccardserieslist'><a href='?p=collections/findingaid&amp;id=$objCollection->ID&amp;q=$_ARCHON->QueryStringURL&amp;rootcontentid=$ID#id$ID'>" . $objContent->toString() . "</a></span><br/>\n");
            }
            else
            {

               $objInfoRestrictedPhrase = Phrase::getPhrase('informationrestricted', PACKAGE_CORE, 0, PHRASETYPE_PUBLIC);
               $strInfoRestricted = $objInfoRestrictedPhrase ? $objInfoRestrictedPhrase->getPhraseValue(ENCODE_HTML) : 'Information restricted, please contact us for additional information.';
               echo("<span class='ccardserieslist'>{$strInfoRestricted}</span><br/>\n");
            }
         }
      }

      $_ARCHON->PublicInterface->DisableTheme = $DisableTheme;
      ?>
               </div>
                  <?php
               }


               if(!empty($objCollection->OtherURL))
               {
					// only apply google analytics if not logged in as admin
					if(!$_ARCHON->Security->userHasAdministrativeAccess())
					{
				  $onclick = ($_ARCHON->config->GACode && $_ARCHON->config->GACollectionsURL) ? "onclick='javascript: pageTracker._trackPageview(\"{$_ARCHON->config->GACollectionsURL}\");'" : "";
					}
                  ?>
               <div class='ccardcontent'><span class='ccardlabel'>Detailed list of collection contents:</span> <a href='<?php echo($objCollection->getString('OtherURL')); ?>' <?php if(!$_ARCHON->Security->userHasAdministrativeAccess()) {echo($onclick);} ?>><?php echo($objCollection->getString('OtherURL')); ?></a></div>
                  <?php
               }
			   if(!empty($objCollection->OtherNote))
               {
                  ?>
                  <div class='ccardcontent'><?php echo($objCollection->getString('OtherNote')); ?></div>
                  <?php
               }
               ?>
         </div>
            <?php
         } else {
			echo("<div id='ccardscope' class='mdround'><div class='ccardcontent'><span class='ccardlabel'>Descriptive note:</span> This collection is currently unprocessed. <p>Please contact the Illinois History and Lincoln Collections at <a href='mailto:ihlc@library.illinois.edu'>ihlc[at]library.illinois.edu</a> for more information about the contents of this collection and its processing status.</p></div></div>");
		 }
         
/*location information, staff access only*/

if($_ARCHON->Security->verifyPermissions(MODULE_COLLECTIONS, READ))
         {
         ?>

   <?php
   if(!empty($objCollection->LocationEntries))
   {
      ?>
		<div id='ccardlocation' class='mdround'>

            <div class='ccardcontents'>
			
               <span class='ccardstafflabel'>Storage Locations (staff view only):</span>
			   
                  <table id='locationtable' border='1'>
                     <tr>
                        <th>Content</th>
                        <th>Location</th>
                        <th>Range</th>
                        <th>Section</th>
                        <th>Shelf</th>
                        <th>Extent</th>
                     </tr>
                     <tr>
                        <td>
      <?php echo($_ARCHON->createStringFromLocationEntryArray($objCollection->LocationEntries, '&nbsp;</td></tr><tr><td>', LINK_EACH, false, '&nbsp;</td><td>')); ?>
                        </td>
                     </tr>
                  </table>
				  <br /><br />
				  <em>Note: To print the location information, please use the "<?php echo("<a href='?p=collections/controlcard&amp;id=" . $objCollection->ID . "&amp;templateset=print&amp;disabletheme=1'>Printer-friendly</a>");?>" version of this page.</em>
      <?php
   }
   

   
   ?>
            </div>


         </div>

   <?php
}
		 
		 ?>

		 </div>
 <!--end div ccardleft -->
 <?php
 /**
 if ($_ARCHON->Security->isAuthenticated()) {
	echo("<div class='hide-link'><a href='?p=collections/controlcard&amp;id=" . $objCollection->ID . "'>Reload without highlighting</a></div>");
}
*/
?>