<?php
isset($_ARCHON) or die();

	echo("<h1 id='titleheader'>" . strip_tags($_ARCHON->PublicInterface->Title) . "</h1>\n");

?>
	

<div id='themeindex' class='bground'>

<div style="width:40%" class="bground textcontainer">
<h2>Deep Search</h2><p style='text-align:center'>Use Google to search box and folder lists<br />(PDF files only)</p>
<div style='text-align:center'>				
    <form name="form1" action="https://www.google.com/search" class="search">
    <input type="hidden" name="hq" value="inurl:www.library.illinois.edu/ihx/inventories">
	<input type="text" size="25" name="q" class="searchinput" style='border:solid 1px #ddd' placeholder="Search inventory lists">
	<input type="submit" value="Find" class="button" style='font-size:1em'></form>
</div>
</div>					
<div style="text-align:center; width:60%;" class="bground textcontainer"><strong>NOTE: </strong>This search box uses Google to search several hundred pages of box and folder listings that exist only in PDF format.  These lists are <span style='color:red;font-weight:bold'>NOT</span> directly searchable through the search box in the top navigation bar. If you do not find what you are looking for, please <a href='mailto:ihlc@library.illinois.edu'>contact the IHLC</a> for additional assistance.</p>
</div>



