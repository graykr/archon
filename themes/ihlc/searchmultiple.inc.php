<?php
isset($_ARCHON) or die();

	echo("<h1 id='titleheader'>" . strip_tags($_ARCHON->PublicInterface->Title) . "</h1>\n");

?>
	

<div class="bground textcontainer box5">
<h2>Search for Archival Collections throughout the University of Illinois Library</h2>
<p>Expand your search to look for archival materials held in additional special collections units at the University of Illinois at Urbana-Champaign Library.</p> 
<p>Use the Google Custom Search box below to search across collections and record series held at the: 
<ul>
<li><a href="https://www.library.illinois.edu/rbx/">Rare Book & Manuscript Library</a></li>
<li><a href="https://www.library.illinois.edu/ihx/">Illinois History & Lincoln Collections</a></li>
<li><a href="https://archives.library.illinois.edu/">University Archives</a> (including the <a href="https://archives.library.illinois.edu/slc/">Student Life & Culture Archives</a> and the <a href="https://archives.library.illinois.edu/sousa/">Sousa Archives & Center for American Music</a>)</li>
<li><a href="https://archives.library.illinois.edu/ala/">American Library Association Archives</a></li></ul>
This searches both the summaries of collections and records series in each database as well as PDF finding aids.</p>
<script>
  (function() {
    var cx = '000935762790068275410:igiom_czkli';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<gcse:search></gcse:search>
</div>
