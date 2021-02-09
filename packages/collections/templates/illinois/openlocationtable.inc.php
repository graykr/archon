<?php
	if(!empty($objCollection->LocationEntries))
            {
               ?>
            <span class='ccardlabel' >Available for use at:</span><br/><br/>


               <table id='locationtable' border='1' style='margin-left:0'>
                  <tr>

                     <th style='width:400px'>Service Location</th>
                     <th style='width:100px'>Boxes</th>
                  </tr>



      <?php
      foreach($objCollection->LocationEntries as $loc)
      {
         echo("<tr>");

	if($loc->LocationID ==11)
         {
            echo("<td><b>Temporarily unavailable.  Please contact the archives for more information.</b></td>");
         }

         elseif($loc->LocationID < 5 || ($loc->LocationID > 7 and $loc->LocationID < 22) || $loc->LocationID == 34)
         {
            echo("<td>Archives Research Center, 1707 S. Orchard</td>");
         }
         elseif($loc->LocationID == 23 || $loc->LocationID == 29)
         {
            echo("<td>SACAM, Band Building</td>");
         }
         elseif($loc->LocationID == 33)
         {
            echo("<td>Online: See links above or <a href='https://archives.library.illinois.edu/email-ahx.php?this_page=https://archives.library.illinois.edu". urlencode($_SERVER['REQUEST_URI'])."'>contact us for help.</a></td>");
         }
         elseif($loc->LocationID >= 27 and $loc->LocationID <=32 )
         {
            echo("<td>Room 146 Main Library, Prior Request Preferred</td>");
         }
         
         elseif($loc->LocationID == 39 )
         {
            echo("<td>Room 146 Main Library</td>");
         }
         else
         {
            echo("<td>Offsite: Prior notice required</td>");
         }
         echo ("<td>" . $loc->Content);
		 
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
      echo("<span class='ccardlabel'>Service Location:</span><br/>Please <a href='https://archives.library.illinois.edu/email-ahx.php?this_page=https://archives.library.illinois.edu". urlencode($_SERVER['REQUEST_URI'])."'>Email us to request a hi-resolution copy.</a>>contact the Archives</a> for assistance. </span>");
   }
   ?>