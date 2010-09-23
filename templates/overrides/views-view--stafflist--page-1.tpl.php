<div style='margin-bottom:25px; margin-top:5px;'>
<?php  echo($view->display['page_1']->display_options['header']);?>
</div>

<div style='margin-top:15px; margin-left:15px;'>
	<ul>
		<?php if ($rows): ?>
			<?php print $rows; ?>
		<?php elseif ($empty): ?>
			<?php print $empty; ?>
		<?php endif; ?>
	</ul>
</div>
