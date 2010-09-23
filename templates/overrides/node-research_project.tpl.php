<?php

$collectionNodeHTML="<div style='margin:15px 0 10px 0;'>".$node->content['body']['#value']."</div>";
$collectionNodeHTML.="<div><a href='".$node->field_link_url[0]['value']."'>".$node->field_link_url[0]['value']."</a></div>";

echo $collectionNodeHTML;

?>
