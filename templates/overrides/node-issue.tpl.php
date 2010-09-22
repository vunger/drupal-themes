<?php 
	if (user_is_logged_in()) {
		$issuePdfLink=$node->field_restrictedissuepdf[0][filepath];
	} else {
		$issuePdfLink=$node->field_fullissuepdf[0][filepath];
	}

	$issueVolume=$node->field_issuevolume[0]['value'];
	$issueNo=$node->field_issuenumber[0]['value'];
	$monthValue=$node->field_issuemonthvalue[0]['value'];

	// Build Breadcrumbs
	$breadcrumb = array();
	$breadcrumb[] = l('Home', '<front>');
	$breadcrumb[] = l('All Issues', 'issues');
	$breadcrumb[] = l("Volume $issueVolume", "issues/volume-$issueVolume");
	$breadcrumb[] = l('Issue '.$issueNo.' ('.$monthValue.')', 'node/'.$node->nid); // Link to current URL

	// Set Breadcrumbs
	drupal_set_breadcrumb($breadcrumb);

	$titleTextToUse='Volume '.$issueVolume.', Issue '.$issueNo.' ('.$monthValue.')';
	drupal_set_title($titleTextToUse);

	$bodyToUse=$node->content['body']['#value'];
	$imgSrc=theme('imagecache', 'large_cover_preview', $node->field_issuecover[0][filepath], '', '', array('style'=>'border:2px solid #BBB;'));

	$htmlToOutput=<<<EOT
		<p>$bodyToUse</p>
		<div style='text-align:center;'><a href='/$issuePdfLink'>$imgSrc</a></div>
EOT;

	echo $htmlToOutput;
?>