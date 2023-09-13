<?php

/**add request button, or launch a modal with the location table if variable locations */
		if($requestLink) {
			if($_ARCHON->config->RequestHasConsistentLocation){
				echo("<a href='" . $requestLink . "' target='_blank'>");
			} else {
				echo("<a id='requestModalLink'>");
			}
			echo("<img src='" . $_ARCHON->PublicInterface->ImagePath . "/box.png' alt='Request' style='padding-right:2px'/>");
			echo($_ARCHON->config->RequestLinkText ? $_ARCHON->config->RequestLinkText : "Submit request");
			echo("</a> | ");
		}
		
?>

<!-- The Modal to show request locations -->
<div id="requestModal" class="request-modal" style="display:none">

  <!-- Modal content -->
  <div class="request-modal-content" >
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

const filterBox = document.querySelector('#requestModal .locationFilter');
var $k =jQuery.noConflict();
filterBox.addEventListener('input', filterBoxes);

function filterBoxes(e) {
	var filterValue = (e.target.value).toLowerCase();
    $k("#requestModal .locationTableBody tr").filter(function() {
        var $t = $(this).children().last();
		$k(this).toggle($k($t).text().toLowerCase().indexOf(filterValue) > -1)
    });
    }

const filterSelect = document.querySelector('#requestModal #locations');
filterSelect.addEventListener('input',filterSelection);

function filterSelection(f) {
	var selectValue = $k('#requestModal #locations option:selected').text().toLowerCase();
	$k("#requestModal .locationTableBody tr").filter(function() {
		$k(this).toggle($k(this).text().toLowerCase().indexOf(selectValue) > -1)
    });
}

</script>

