<?php
isset($_ARCHON) or die();

	echo("<h1 id='titleheader'>" . strip_tags($_ARCHON->PublicInterface->Title) . "</h1>\n");

?>
	

<div id='themeindex' class='bground'>

<div id='pdfsearchbox' class="bground">
<h2 style='margin-top:.1em'><label for="q">PDF/Deep Search</label></h2>
<div style='text-align:center'>				
    <form name="form1" action="https://www.google.com/search" class="search">
    <input type="hidden" name="hq" value="site:files.archon.library.illinois.edu/uasfa/ OR site:archives.library.illinois.edu/uasfa/" />
    <input type="hidden" name="safe" value="off" />
    <input type="hidden" name="filter" value="0" />
	<input id="q" type="text" size="25" name="q" class="searchinput" style='border:solid 1px #ddd'>
	<input type="submit" value="Search" class="button" style='font-size:1em'></form>
</div>
</div>					
<div id="pdfsearchinfo" class="bground">This page uses Google to search over 17,000 pages of <a href="https://archives.library.illinois.edu/uasfa/">box/folder listings that exist only in PDF format.</a>  These lists are <span style='color:red;font-weight:bold'>NOT</span> directly searchable through the search box in the top navigation bar. If you do not find what you are looking for, please <a href='http://www.library.uiuc.edu/archives/email-ahx.php'>contact the Archives</a> for additional assistance.</p></div>


<div>

<?php

// courtesty of http://www.hawkee.com/snippet/1749/

function list_files($dir)
{
  if(is_dir($dir))
  {
    if($handle = opendir($dir))

    {
      echo ("<h2>Complete list of PDF inventories:</h2><ul>");
      while(($file = readdir($handle)) !== false)
      {
        if($file != "." && $file != ".." && $file != "Folder Settings" && $file != "desktop.ini" && $file != "index.php")  /*pesky windows, images..*/
        {
          echo '<li><a href="https://files.archon.library.illinois.edu/uasfa/'.$file.'">'.$file.'</a></li>'."\n";
					//echo $dir.'<br/>';
        }
      }
      echo ("</ul>");
      closedir($handle);
    }
  }
}

list_files("/archon-upload/uasfa/.");

?>


</div>


