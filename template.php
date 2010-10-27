<?php
// $Id$

/**
 * @file
 * ETCDrupal customizations of parent theme, 'Sky'
 */

/** 
 * Implementation of template_preprocess_page()
 * Rewrites front page meta title
 * Builds breadcrumb trail from auto-generated alias
 */
function etcdrupal_preprocess_page(&$vars) {
  $head_title = array(variable_get('site_name', 'Drupal'));

  if (! drupal_is_front_page()) {
    if (drupal_get_title()) {
      $head_title[] = strip_tags(drupal_get_title());
    }
    else {
      if (variable_get('site_slogan', '')) {
        $head_title[] = variable_get('site_slogan', '');
      }
    }
  }
  
  $vars['head_title'] = implode(' - ', $head_title);
}

/**
 * Implementation of theme_node_submitted()
 * Removes user name from node submission info.
 */
function etcdrupal_node_submitted($node) {
  return t('Posted @datetime',
    array(
      '@datetime' => format_date($node->created),
    ));
}

/**
 * Implementation of theme_breadcrumb()
 * Builds breadcrumb trail from automated URL aliases
 */
function etcdrupal_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    $breadcrumb[] = drupal_get_title();
    return '<div class="breadcrumb">'. implode(' | ', $breadcrumb) .'</div>';
  }
}
