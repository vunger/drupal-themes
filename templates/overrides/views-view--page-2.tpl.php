<?php echo($view->display['page_2']->display_options['header']); ?>

<ul class="menu">
	<?php if ($rows): ?>
		<?php print $rows; ?>
	<?php elseif ($empty): ?>
		<?php print $empty; ?>
	<?php endif; ?>
</ul>