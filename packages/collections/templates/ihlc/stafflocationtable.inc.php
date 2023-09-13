<?php
if(!empty($objCollection->LocationEntries))
{
    if(count($objCollection->LocationEntries)>1){
       if(!$_ARCHON->config->ExcludeRequestLink[$objCollection->RepositoryID]){
        ?>
           <label for="filterBy">Filter by any text: </label><input class="staffLocationFilter" id="filterBy" type="text">
           <br /><br />
           <label for="filterBy">Filter by box: </label><input class="staffBoxFilter" id="filterBy" type="text">

        <?php
      }
    }
        ?>
           <div><br/><span class='ccardlabel'>Storage Locations:</span></div>
           <table id='locationtable' border='1'>
              <thread><tr>
                 <th>Content</th>
                 <th>Location</th>
                 <th>Range</th>
                 <th>Section</th>
                 <th>Shelf</th>
                 <th>Extent</th>
                 <?php if($requestLink) {
                      echo("<th>Request</th>");
                  }
                  ?>
              </tr></thread>
              <tbody class='locationTableBody'>
              <tr>
              <td>
        <?php //echo($_ARCHON->createStringFromLocationEntryArray($objCollection->LocationEntries, '&nbsp;</td></tr><tr><td>', LINK_EACH, false, '&nbsp;</td><td>')); ?>
        <?php
        if(!$requestLink){
            echo($_ARCHON->createStringFromLocationEntryArray($objCollection->LocationEntries, '&nbsp;</td></tr><tr><td>', LINK_EACH, false, '&nbsp;</td><td>'));
        } else {
            $arrLocationEntries = $objCollection->LocationEntries;
            $locLast = end($arrLocationEntries);
            foreach ($arrLocationEntries as $loc)
            {
                  echo($loc->toString(LINK_EACH, false, '&nbsp;</td><td>', true));
                  echo("<td title='Request content: $loc->Content'>");
                  include("packages/collections/templates/{$_ARCHON->PublicInterface->TemplateSet}/requestlinkforboxes.inc.php");
                  echo("</td>");
                  if($loc->ID != $objLast->ID)
                  {
                     echo('&nbsp;</td></tr><tr><td>');
                  }
            }
          }
        ?>
                 </td></tbody>
              </tr>
           </table>
<?php
}
?>