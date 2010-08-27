<?php
// $Id$

/**
 * @file
 * The guts of the theme :)
 */


/*
 * Initialize theme settings
 */
global $theme_key;

if (is_null(theme_get_setting('skymall_layout'))) {

  // Save default theme settings
  $defaults = array(
    'skymall_background' => NULL,
    'skymall_background_header' => NULL,
    'skymall_breadcrumbs' => 0,
    'skymall_breadcrumbs_sep' => '&raquo;',
    'skymall_links' => NULL,
    'skymall_links_active' => NULL,
    'skymall_links_hover' => NULL,
    'skymall_links_visited' => NULL,
    'skymall_font' => 'lucida',
    'skymall_font_headings' => 'lucida',
    'skymall_font_size' => '12px',
    'skymall_header_height' => 'auto',
    'skymall_layout' => 'fixed_960',
    'skymall_custom_layout' => NULL,
    'skymall_nav_alignment' => 'center',
    'skymall_sub_navigation_size' => '15em',
  );

  // Get default theme settings.
  $settings = theme_get_settings($theme_key);

  // Don't save the toggle_node_info_ variables.
  if (module_exists('node')) {
    foreach (node_get_types() as $type => $name) {
      unset($settings['toggle_node_info_'. $type]);
    }
  }
  // Save default theme settings.
  variable_set(
    str_replace('/', '_', 'theme_'. $theme_key .'_settings'),
    array_merge($defaults, $settings)
  );

  // Force refresh of Drupal internals
  theme_get_setting('', TRUE);
}

/**
 * Add Custom Generated CSS File
 * This file is generated each time the theme settings page is loaded.
 * @todo Test subthemes.
 */
$custom_css = file_directory_path() .'/' . $theme_key . '/custom.css';
if (file_exists($custom_css)) {
  drupal_add_css($custom_css, 'theme', 'all', TRUE);
}

/**
 * Implementation of hook_theme().
 * This function provides a one-stop reference for all
 */

function skymall_theme() {
  return array(
    'breadcrumb' => array(
      'arguments' => array('breadcrumb' => array()),
      'file' => 'functions/theme-overrides.inc',
    ),
    'conditional_stylesheets' => array(
      'file' => 'functions/theme-custom.inc',
    ),
    'feed_icon' => array(
      'arguments' => array('url' => NULL, 'title' => NULL),
      'file' => 'functions/theme-overrides.inc',
    ),
    'form_element' => array(
      'arguments' => array('element' => NULL, 'value' => NULL),
      'file' => 'functions/theme-overrides.inc',
    ),
    'fieldset' => array(
      'arguments' => array('element' => NULL),
      'file' => 'functions/theme-overrides.inc',
    ),
    'menu_local_tasks' => array(
      'arguments' => NULL,
      'file' => 'functions/theme-overrides.inc',
    ),
    'more_link' => array(
      'arguments' => array('url' => array(), 'title' => NULL),
      'file' => 'functions/theme-overrides.inc',
    ),
    'pager' => array(
      'arguments' => array('tags' => array(), 'limit' => NULL, 'element' => NULL, 'parameters' => array(), 'quantity' => NULL),
      'file' => 'functions/theme-overrides.inc',
    ),
   'status_messages' => array(
      'arguments' => array('display' => NULL),
      'file' => 'functions/theme-overrides.inc',
    ),
    'status_report' => array(
      'arguments' => array('requirements' => NULL),
      'file' => 'functions/theme-overrides.inc',
    ),
    'table' => array(
      'arguments' => array('header' => NULL, 'rows' => NULL, 'attributes' => array(), 'caption' => NULL),
      'file' => 'functions/theme-overrides.inc',
    ),
    'render_attributes' => array(
      'arguments' => array('attributes'),
      'file' => 'functions/theme-custom.inc',
    ),
    /* Biblio theme hooks */
    'biblio_entry' => array(
      'arguments' => array('node' => NULL, 'base' => 'bibilo', 'style' => 'classic', 'inline' => FALSE),
      'file' => 'functions/theme-overrides.inc',
    ),
    'biblio_export_links' => array(
      'arguments' => array('node' => NULL),
      'file' => 'functions/theme-overrides.inc',
    ),
    'biblio_download_links' => array(
      'arguments' => array('node' => NULL),
      'file' => 'functions/theme-overrides.inc',
    ),
    'biblio_openurl' => array(
      'arguments' => array('openurl' => ''),
      'file' => 'functions/theme-overrides.inc'
    )
  );
}

/**
 * Implementation of hook_preprocess().
 *
 * @param $vars
 * @param $hook
 * @return Array
 */
function skymall_preprocess(&$vars, $hook) {

  // Only add the admin.css file to administrative pages
  if (arg(0) == 'admin') {
    drupal_add_css(path_to_theme() .'/css/admin.css', 'theme', 'all', TRUE);
  }

 /**
  * This function checks to see if a hook has a preprocess file associated with
  * it, and if so, loads it.
  */
  if (is_file(drupal_get_path('theme', 'skymall') .'/preprocess/preprocess-'. str_replace('_', '-', $hook) .'.inc')) {
    include('preprocess/preprocess-'. str_replace('_', '-', $hook) .'.inc');
  }
}

