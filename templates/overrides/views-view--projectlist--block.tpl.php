<div>
	<ul style='margin-left:10px; list-style:none;'>
		<?php if ($rows): ?>
			<?php print $rows; ?>
		<?php elseif ($empty): ?>
			<?php print $empty; ?>
		<?php endif; ?>
	</ul>
	<div style='text-align:right; color:#000;'>
		<?php echo l('More...','current-projects',array('attributes'=>array('style'=>'color:#444;'))); ?>
	</div>
</div>

