<?php
// $Id: fuzzysearch-result.tpl.php,v 1.1 2010/03/06 23:02:59 awolfey Exp $

/**
 * @file
 * Template for fuzzysearch results.
 */
$textOfLinkTitle="Volume ".$node->field_issuevolume[0]['value'].", Issue ".$node->field_issuenumber[0]['value'];
$headerHtmlLink="<h3 style='margin-top:13px; margin-bottom:0; padding-bottom:0;'>$textOfLinkTitle</h3>";
$imageHtmlCode=theme('imagecache', 'small_cover_preview', $node->field_issuecover[0]['filepath'], '', '', array('style'=>'border:2px solid #BBB;'));
?>
<div id="node-<?php print $node->nid; ?>" class="node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?> clear-block">

	<div style='float:left; width:120px; padding:10px 20px 10px 10px;'>
		<?php
			echo l($imageHtmlCode, 'node/'.$node->nid, $options = array('html' => TRUE, 'attributes'=>array('style'=>'padding:0; margin:0;')));
		?>
	</div>

	<div style='float:left; width:510px;'>
		<?php
			echo l($headerHtmlLink, 'node/'.$node->nid, $options = array('html' => TRUE, 'attributes'=>array('style'=>'padding:0; margin:0;')));
		?>
	</div>

	<div style='float:left; width:510px;'>
		<p style='font-style:italic; margin:0; padding:0;'><?php echo $node->field_issuemonthvalue[0]['value']; ?></p>
	</div>

	<div style='float:left; width:510px;'>
		<?php echo truncate_utf8($content, 635,TRUE, TRUE); ?></p>
	</div>

	<div style='clear:both;'></div>

</div>