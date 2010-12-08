<?php
// $Id: content-field.tpl.php,v 1.1.2.5 2008/11/03 12:46:27 yched Exp $

/**
 * @file content-field.tpl.php
 * Default theme implementation to display the value of a field.
 *
 * Available variables:
 * - $node: The node object.
 * - $field: The field array.
 * - $items: An array of values for each item in the field array.
 * - $teaser: Whether this is displayed as a teaser.
 * - $page: Whether this is displayed as a page.
 * - $field_name: The field name.
 * - $field_type: The field type.
 * - $field_name_css: The css-compatible field name.
 * - $field_type_css: The css-compatible field type.
 * - $label: The item label.
 * - $label_display: Position of label display, inline, above, or hidden.
 * - $field_empty: Whether the field has any valid value.
 *
 * Each $item in $items contains:
 * - 'view' - the themed view for that item
 *
 * @see template_preprocess_field()
 */
?>
<?php if (!$field_empty) : ?>
<div class="field field-type-<?php print $field_type_css ?> field-<?php print $field_name_css ?>">
  <?php if ($label_display == 'above') : ?>
    <div class="field-label"><?php print t($label) ?>:&nbsp;</div>
  <?php endif;?>
  <div class="field-items">
    <?php if ($label_display == 'inline') { ?>
      <div class="field-label-inline<?php print($delta ? '' : '-first')?>">
        <?php print t($label) ?>:&nbsp;</div>
    <?php } ?>
    <?php
      $count = 1;
      $item_list = array();

      foreach ($items as $delta => $item) :
        if (!$item['empty']) : 
          $item_list[] = '<span class="field-item '. ($count % 2 ? 'odd' : 'even') .'">'
                        .$item['view']
                        .'</span>';
          $count++;
        endif;
      endforeach;

      if (!empty($item_list)) {
        print t('In') .' ';

        if (count($item_list) > 1) {
          // If multiple lanaguges, output a comma-delimited list:
          print implode(', ', array_slice($item_list, 0, -1));
          
          if (count($item_list) > 2) {
            // serial comma before 'and'
            print ',';
          }
          print ' '. t('and') .' ';
        }
        
        // Usually, there's only one item in the list
        print $item_list[count($item_list)-1] .'.';
      }
    ?>
    </div>
</div>
<?php endif; ?>
