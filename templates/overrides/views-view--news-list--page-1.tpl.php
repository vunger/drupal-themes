<h1><?php echo variable_get('site_name', 'Electronic Text Center at UNB Libraries'); ?></h1>

<div style='margin-bottom:25px; margin-top:5px;'>
<?php  echo($view->display['page_1']->display_options['header']);?>
</div>

<div class="title">
	<h2>Latest ETC News:</h2>
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
