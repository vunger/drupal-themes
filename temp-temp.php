<?php

// Custom User Profile Display Template
// Jacob Sanford
// February 2010

// Set title to something other than nonsensical user alaias
//

drupal_set_title($account->profile_fullname);

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


// If OG exists
//

if ($account->og_groups) {
	$profiledumper.="<h2 style='margin-top:20px;'>Subscribed Groups</h2>";
	$profiledumper.="<ul>";
}

foreach($account->og_groups as $curgroup) {
	$grouptitle=$curgroup['title'];
	$groupnid=$curgroup['nid'];

	$profiledumper.="<li>".l($grouptitle,"node/$groupnid")."</li>";
}

if ($account->og_groups) {
        $profiledumper.="</ul>";
}



// Define the container close.

$profiledumper.='</div>';



// Check if user has node ownerships.
// If so, load array
//

$curuid=$account->uid;
$querystring="SELECT node.nid,node.uid FROM node WHERE uid=$curuid ORDER by nid desc";

$result = db_query($querystring,$rid);

while ($u = db_fetch_object($result)) {
	$node = node_build_content(node_load(array('nid' => $u->nid)), FALSE, FALSE);
	$node->teaser = drupal_render($node->content);
	$items[] = l($node->title,"node/$u->nid");
}


// If items has content, dump it with header
//
if ($items) {
	$profiledumper.='<h2 style="margin-top:20px;">Latest Contributions</h2>';
	$profiledumper.=theme('item_list', $items);
}

// echo theme('item_list', $items);

// Dump everything out.
//

echo $profiledumper;



?>
