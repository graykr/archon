<?php
if(!empty($objCollection->LocationEntries) && !empty($_ARCHON->config->RequestLinkLocationList) && !empty($_ARCHON->config->PublicLocationInfoList))
               {
                  ?>
      <span class='ccardlabel' id='requestlocations'>Available for use at:</span><br/><br/>


         <table id='locationtable' border='1' style='margin-left:0'>
            <tr>

               <th style='width:400px'>Service Location</th>
               <th style='width:100px'>Boxes</th>
            </tr>



                  <?php
                  foreach ($objCollection->LocationEntries as $loc)
                  {

                     $locationcode = $_ARCHON->config->RequestLinkLocationList[$loc->LocationID];
                     $locationtext = $_ARCHON->config->PublicLocationInfoList[$locationcode];

                     if ($locationtext)
                     {
                        echo("<td>".$locationtext."</td>");
                     }
                     
                     else
                     {
                        echo("<td>Location information not found. Please contact us for assistance.</td>");
                     }
					 
					      echo ("<td>". $loc->Content);

/** Add request links to each row with the container info.**/
                     if(!$_ARCHON->config->RequestHasConsistentLocation and $requestLink){
                        echo("<br/><a href='" . $requestLink);
                        
                        //add on the location code based on the location array, or the default if location id not in the array
                        if($_ARCHON->config->RequestVarLocation){
                           if($_ARCHON->config->RequestLinkLocationList[$loc->LocationID]) {
                              echo($_ARCHON->config->RequestVarLocation . $_ARCHON->config->RequestLinkLocationList[$loc->LocationID]);
                           } elseif($_ARCHON->config->RequestDefaultLocation) {
                              echo($_ARCHON->config->RequestVarLocation .  $_ARCHON->config->RequestDefaultLocation);
                           }
                        }
                        
                        //send info about which boxes the request was made from
                        if($_ARCHON->config->RequestVarBoxes){
                           echo($_ARCHON->config->RequestVarBoxes . $loc->Content);
                        }
                        
                        echo("' target='_blank' class='request-button'>");
                        if($_ARCHON->config->RequestLinkText) {
                           echo($_ARCHON->config->RequestLinkText);
                        }else {
                           echo("Submit request");
                        }
                        echo("</a>");
					      }
/**end section for request links **/

					      echo("</td></tr>");
					}
            echo ('</table>');
         }

         else
         {
            echo("<div id='ccardstaff'><span class='ccardlabel' id='requestlocations'>Service Location:</span><br/>Please <a href='http://archives.library.illinois.edu/ala/contact-us/'>contact the Archives</a> for assistance. </span></div>");

         }
		 ?>