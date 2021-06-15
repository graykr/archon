<?php
/** Add request link, or launch a modal with the location table if variable locations */
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

/* Modal to show request locations; note that additional CSS is needed in the style sheet for the modal to function	*/
?>
<div id="requestModal" class="request-modal" style="display:none">

  <div class="request-modal-content">
    <span class="request-modal-close">&times;</span>
      <?php
		if(file_exists("packages/collections/templates/{$_ARCHON->PublicInterface->TemplateSet}/openlocationtable.inc.php")){
			include("packages/collections/templates/{$_ARCHON->PublicInterface->TemplateSet}/openlocationtable.inc.php");
		} else {
			echo("Please see location table below at left.");
		}
		?>
  </div>

</div>

<script>
var modal = document.getElementById("requestModal");

var btn = document.getElementById("requestModalLink");

var span = document.getElementsByClassName("request-modal-close")[0];

btn.onclick = function() {
  modal.style.display = "block";
}

span.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
