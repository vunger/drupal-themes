<?php
	$textOfLinkTitle="Volume ".$fields['field_issuevolume_value']->content.", Issue ".$fields['field_issuenumber_value']->content;
	$headerHtmlLink="<h3 style='margin-top:13px; margin-bottom:0; padding-bottom:0;'>$textOfLinkTitle</h3>";
	$imageHtmlCode=theme('imagecache', 'small_cover_preview', $fields['field_issuecover_fid']->content, '', '', array('style'=>'border:2px solid #BBB;'));
?>
<li>
<div style='float:left; width:120px; padding:10px 20px 10px 10px;'>
	
<?php
	echo l($imageHtmlCode, 'node/'.$fields['nid']->content, $options = array('html' => TRUE, 'attributes'=>array('style'=>'padding:0; margin:0;')));
?>

</div>

<div style='float:left; width:510px;'>

<?php

echo l($headerHtmlLink, 'node/'.$fields['nid']->content, $options = array('html' => TRUE, 'attributes'=>array('style'=>'padding:0; margin:0;')));

?>

</div>

<div style='float:left; width:510px;'>
	<p style='font-style:italic; margin:0; padding:0;'><?php echo $fields['field_issuemonthvalue_value']->content; ?></p>
</div>

<div style='float:left; width:510px;'>
	<?php echo $fields['body']->content; ?></p>
</div>

<div style='clear:both;'></div>
</li>