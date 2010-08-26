<?php

// Init dumper
//
$profiledumper='';


// Display the picture, if it exists
// With larger photos, might want to think about floating divs here to everything wraps nice.
//

if ($account->picture) {

$profiledumper.=<<<EOT
<div class="picture">
<img src="/$account->picture" alt="$account->profile_fullname">
</div>
EOT;

}


// Define display block other than photo.
//

// Generate E-Mail link HTML
//

$emaillink=l($account->mail, "mailto:$account->mail", array(absolute => TRUE));


// Define the container open.

$profiledumper.='<div class="custom_profiles">';

if ($account->profile_accreditations!="") { $profiledumper.="<div class=\"fields\" style=\"font-size:14px; margin-top:-5px;\">$account->profile_accreditations</div>"; }

$profiledumper.=<<<EOT
<div class="fields" style="font-style: italic;">$account->profile_position_title</div>
<div class="fields">$account->profile_department</div>
<div class="fields">$account->profile_affiliation</div>
<div class="fields">$account->profile_province</div>
<div class="fields">$emaillink</div>
<div class="fields" style="margin-top:15px;">$account->profile_biography</div>
EOT;

// Define the container close.

$profiledumper.='</div>';

echo $profiledumper;


?>
