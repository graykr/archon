<?php
if(!empty($objCollection->LocationEntries))
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
                     if (($loc->LocationID>171 && $loc->LocationID<191) || $loc->LocationID==200)
                     {
                        echo("<td>Archives Research Center, 1707 S. Orchard St.</td>");
                     }
                     
                     elseif ($loc->LocationID>194 && $loc->LocationID<198)
                     {
                        echo("<td>146 Library, 1408 W. Gregory Drive</td>");
                     }

                     else
                     {
                        echo("<td>Offsite: 24 hours notice required</td>");
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