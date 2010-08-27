<?php
// Modify elements of the search form
$vars['form']['search_block_form']['#title'] = '';
//$vars['form']['submit']['#value'] = t('Go');

// Rebuild the rendered version (search form only, rest remains unchanged)
unset($vars['form']['search_block_form']['#printed']);
$vars['search']['search_block_form'] = drupal_render($vars['form']['search_block_form']);

// Rebuild the rendered version (submit button, rest remains unchanged)
//unset($vars['form']['submit']['#printed']);
//$vars['search']['submit'] = drupal_render($vars['form']['submit']);

// Collect all form elements to make it easier to print the whole form.
$vars['search_form'] = implode($vars['search']);
