<?php

echo "<div style='font-style:italic;'>".date("D, F j, Y",$node->changed)."</div>";
echo "<div style='margin:15px 0 10px 0;'>".$node->body."</div>";

print theme('links', $node->links);

?>
