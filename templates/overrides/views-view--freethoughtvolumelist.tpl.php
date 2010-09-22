<?php
if ($view->args[0]!='') {
	preg_match("/volume-([0-9]+)/i", $view->args[0], $matches);
	$volume=$matches[1];
	$titleToUse="All Issues in Volume $volume :";

	// Build Breadcrumbs
	$breadcrumb = array();
	$breadcrumb[] = l('Home', '<front>');
	$breadcrumb[] = l('All Issues', 'issues');
	$breadcrumb[] = l("Volume $volume", "issues/volume-$volume");

	$volumeListText='';

} else {
	$titleToUse='All Issues :';

	$breadcrumb = array();
	$breadcrumb[] = l('Home', '<front>');
	$breadcrumb[] = l('All Issues', 'issues');

	$volumeListList=views_embed_view("listofuploadedvolumes","block_1");

	$volumeListText=<<<EOT
		<div style='margin-top:5px; margin-bottom:20px;'>
			<div class="title">
				<h2>Browse By Volume :</h2>
			</div>
			$volumeListList
		</div>
EOT;
}

// Set Breadcrumbs
drupal_set_breadcrumb($breadcrumb);

?>

<?php echo $volumeListText; ?>

<div class="title">
	<h2><?php echo $titleToUse; ?></h2>
</div>

<div>
	<ul class='menu'>
		<?php if ($rows): ?>
			<?php print $rows; ?>
		<?php elseif ($empty): ?>
			<?php print $empty; ?>
		<?php endif; ?>
	</ul>
</div>