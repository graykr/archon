<?php
isset($_ARCHON) or die();
?>
<div id='themeindex' class='bground'>
   <h1><label for="q">PDF/Deep Search</label></h1>
   <div id='pdfinput'>
      <form name="form1" action="https://www.google.com/search" class="search">
         <input type="hidden" name="hq" value="site:files.archon.library.illinois.edu/alasfa/ OR site:archives.library.illinois.edu/alasfa/" />
         <input type="hidden" name="safe" value="off" />
         <input type="hidden" name="filter" value="0" />
         <input id="q" type="text" size="25" name="q" class="searchinput" style='border:solid 1px #ddd'>
         <input type="submit" value="Search" class="button" style='font-size:1em'></form>
   </div>

   <div><br/><span class="bold">Note:</span> This page uses Google to search ALL box/folder listings that exist only in PDF format.  These lists are <span style='color:red;font-weight:bold'>NOT</span> directly searchable through the search box at the top right-hand corner of the page.<br/><br/>If you do not find what you are looking for, please <a href='https://archives.library.illinois.edu/ala/contact-us/'>contact the Archives</a> for additional assistance.</div>

</div>

<div>

<?php

// courtesty of http://www.hawkee.com/snippet/1749/

function list_files($dir)
{
  if(is_dir($dir))
  {
    if($handle = opendir($dir))

    {
      echo ("<h2>Complete list of ALA's PDF inventories:</h2><ul>");
      while(($file = readdir($handle)) !== false)
      {
        if($file != "." && $file != ".." && $file != "Folder Settings" && $file != "desktop.ini" && $file != "index.php")  /*pesky windows, images..*/
        {
          echo '<li><a href="https://archives.library.illinois.edu/alasfa/'.$file.'">'.$file.'</a></li>'."\n";
               //echo $dir.'<br/>';
        }
      }
      echo ("</ul>");
      closedir($handle);
    }
  }
}

list_files("/archon-data/alasfa/.");

?>


</div>



