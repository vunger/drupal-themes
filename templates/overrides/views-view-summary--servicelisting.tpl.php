        <ul  style='margin-left:10px; list-style:none;'>
                <?php if ($rows): ?>
                        <?php foreach ($rows as $row) {
                                $liOutputHTML='';
                                $liOutputHTML.='<li>';
                                $liOutputHTML.=l($row->node_title,'node/'.$row->nid);
                                $liOutputHTML.='</li>';
                                echo $liOutputHTML;
                        }?>
                <?php elseif ($empty): ?>
                        <?php print $empty; ?>
                <?php endif; ?>
        </ul>
