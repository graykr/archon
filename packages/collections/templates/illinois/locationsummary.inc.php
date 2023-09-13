<?php
if(!empty($objCollection->LocationEntries) && !empty($_ARCHON->config->RequestLinkLocationList) && !empty($_ARCHON->config->PublicLocationInfoList))
               {
                  ?>
      <span class='ccardlabel' id='requestlocations'>Locations for this record series:</span><br/>

         <?php
         //create list of locations
         $uniqueLocations = array_unique($objCollection->LocationEntries);
         $locationCodes = array();
         foreach($uniqueLocations as $uloc){
            $loccode = $_ARCHON->config->RequestLinkLocationList[$uloc->LocationID];
            $locationCodes[] = $loccode;
         }
         $uniqueLocationCodes = array_unique($locationCodes);
         $selectLocation = "<label for='locations'>Filter by location:</label><select name='locations' id='locations'><option selected value> </option>";
         echo("<ul>");            
            foreach($uniqueLocationCodes as $ucode){
               $loctext = $_ARCHON->config->PublicLocationInfoList[$ucode];
               if ($loctext)
               {
                  echo("<li>".$loctext."</li>");
                  $selectLocation .= "<option value='".$ucode."'>".$loctext."</option>";
               }
                     
               else
               {
               echo("<li>Unidentified location.</li>");
               }
            }    
         echo("</ul>");
		}

/**add request button, or launch a modal with the location table if variable locations */
		if($requestLink) {
         if(!$_ARCHON->config->StaffOnlyRequestLink){
            if($_ARCHON->config->RequestHasConsistentLocation){
               echo("<a href='" . $requestLink . "' target='_blank'>");
            } else {
               if(count($uniqueLocationCodes)>1){
                  echo('<p><em>Click "');
                  echo($_ARCHON->config->RequestLinkText ? $_ARCHON->config->RequestLinkText : "Submit request");
                  echo('" to view locations for each box.</em></p>');
               }
               echo("<a id='requestModalLink2'>");
            }
            echo("<img src='" . $_ARCHON->PublicInterface->ImagePath . "/box.png' alt='Request' style='padding-right:2px'/>");
            echo($_ARCHON->config->RequestLinkText ? $_ARCHON->config->RequestLinkText : "Submit request");
            echo("</a>");
         }
		}
		
?>

<script>
var modal = document.getElementById("requestModal");

var btn2 = document.getElementById("requestModalLink2");

btn2.onclick = function() {
  modal.style.display = "block";
}

</script>

