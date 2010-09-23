<li>
<div>
<?php echo l($fields['title']->content,'node/'.$row->nid,array('attributes'=>array('style'=>'margin:0; padding:0;'))).' - '.$fields['created']->content; ?>
<div style='margin-bottom:10px;'><?php echo $fields['body']->content;?></div>
</div>
</li>

