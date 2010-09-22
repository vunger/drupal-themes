<div style='margin:0 20px 20px 30px;'>
	<ul>
		<?php if ($rows): ?>
			<?php foreach ($rows as $row) { 
				$liOutputHTML='';
				$liOutputHTML.='<li>';
				$liOutputHTML.='<a href="/freethought/issues/volume-'.$row->node_data_field_issuevolume_field_issuevolume_value.'">Volume '.$row->node_data_field_issuevolume_field_issuevolume_value.'</a>';
				$liOutputHTML.='</li>';
				echo $liOutputHTML; 
			}?>
		<?php elseif ($empty): ?>
			<?php print $empty; ?>
		<?php endif; ?>
	</ul>
</div>