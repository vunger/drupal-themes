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
  $vars['breadcrumb'] = theme('breadcrumb', _etcdrupal_get_breadcrumb());
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
    return '<div class="breadcrumb">'. implode(' | ', $breadcrumb) .'</div>';
  }
}

/**
 * Get the breadcrumb trail for the current page.
 * Rewrites core function to call theme-specific breadcrumb builder.
 */
function _etcdrupal_get_breadcrumb() {
  $breadcrumb = drupal_set_breadcrumb();

  if (is_null($breadcrumb)) {
    $breadcrumb = _etcdrupal_get_active_breadcrumb();
  }
  return $breadcrumb;
}

/**
 * Derive breadcrumb for the current page's auto-generated alias
 */
function _etcdrupal_get_active_breadcrumb() {
  $breadcrumb = array();

  // No breadcrumb for the front page.
  if (drupal_is_front_page()) {
    return $breadcrumb;
  }

  // the 'install base' is the portion of $base_url
  // contributed by the multi-site install
  $install_base = _etcdrupal_get_install_base();
  $request_uri = request_uri();

  if (substr_compare($request_uri, $install_base, 0, strlen($install_base)) == 0) {
    $alias = substr($request_uri, strlen($install_base));
  }
  else {
    $alias = $request_uri;
  }
  $alias_tokens = preg_split("/\//", $alias, -1, PREG_SPLIT_NO_EMPTY);

  // We always want a linked 'Home' crumb
  $breadcrumb[] = l(t('Home'), '<front>');

  // Warning! Dicey code.  Assumes the following: 
  // 1. aliases are generated from node titles
  // 2. spaces in titles are replaced with hyphens
  // 3. all components of the URL lead to accessible content, i.e., 
  //    given 'services/digitial-imaging', both 'services' and
  //   'services/digital-imaging' are accessible to the great unwashed.
  while ($token = array_shift($alias_tokens)) {
    $current_alias .= $token;
    
    if (sizeof($alias_tokens) > 0) {
      $breadcrumb[] = l(drupal_ucfirst(str_replace('-', ' ', $token)), $current_alias, array('alias' => TRUE));
    }
    else {
      // Display unlinked breadcrumb for current page
      $breadcrumb[] = drupal_get_title();
    }
    // add slash before appending next token
    $current_alias .= '/';
  }

  return $breadcrumb;  
}

function _etcdrupal_get_install_base() {
  global $base_url;
  static $stored_install_base;

  if (is_null($stored_install_base)) {
    $proto = $_SERVER['HTTPS'] ? 'https://' : 'http://';
    $host = $_SERVER['SERVER_NAME'];
    $port = ($_SERVER['SERVER_PORT'] == 80 ? '' : ':'. $_SERVER['SERVER_PORT']);

    $stored_install_base = substr($base_url, strlen("$proto$host$port"));
  }
  
  return $stored_install_base;
}
