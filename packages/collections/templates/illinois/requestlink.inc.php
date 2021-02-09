<?php

/**add request button, or launch a modal with the location table if variable locations */
		if($requestLink) {
			if($_ARCHON->config->RequestHasConsistentLocation){
				echo("<a href='" . $requestLink . "' target='_blank'>");
			} else {
				echo("<a href='#' id='requestModalLink'>");
			}
			echo("<img src='" . $_ARCHON->PublicInterface->ImagePath . "/box.png' alt='Request' style='padding-right:2px'/>");
			echo($_ARCHON->config->RequestLinkText ? $_ARCHON->config->RequestLinkText : "Submit request");
			echo("</a> | ");
		}
		
?>

<!-- The Modal to show request locations -->
<div id="requestModal" class="request-modal" style="display:none">

  <!-- Modal content -->
  <div class="request-modal-content">
    <span class="request-modal-close">&times;</span>
      <?php
		if(file_exists("packages/collections/templates/illinois/openlocationtable.inc.php")){
			include("packages/collections/templates/illinois/openlocationtable.inc.php");
		} else {
			echo("Please see location table below at left.");
		}
		?>
  </div>

</div>

<script>
// adapted from https://www.w3schools.com/howto/howto_css_modals.asp
// Get the modal
var modal = document.getElementById("requestModal");

// Get the button that opens the modal
var btn = document.getElementById("requestModalLink");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("request-modal-close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

<?php

/**end section with the request button*/
?>