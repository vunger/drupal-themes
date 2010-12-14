<?php
// $Id: template.php,v 1.21 2009/08/12 04:25:15 johnalbin Exp $

/**
 * @file
 * Contains theme override functions and preprocess functions for the theme.
 *
 * ABOUT THE TEMPLATE.PHP FILE
 *
 *   The template.php file is one of the most useful files when creating or
 *   modifying Drupal themes. You can add new regions for block content, modify
 *   or override Drupal's theme functions, intercept or make additional
 *   variables available to your theme, and create custom PHP logic. For more
 *   information, please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/theme-guide
 *
 * OVERRIDING THEME FUNCTIONS
 *
 *   The Drupal theme system uses special theme functions to generate HTML
 *   output automatically. Often we wish to customize this HTML output. To do
 *   this, we have to override the theme function. You have to first find the
 *   theme function that generates the output, and then "catch" it and modify it
 *   here. The easiest way to do it is to copy the original function in its
 *   entirety and paste it here, changing the prefix from theme_ to STARTERKIT_.
 *   For example:
 *
 *     original: theme_breadcrumb()
 *     theme override: STARTERKIT_breadcrumb()
 *
 *   where STARTERKIT is the name of your sub-theme. For example, the
 *   zen_classic theme would define a zen_classic_breadcrumb() function.
 *
 *   If you would like to override any of the theme functions used in Zen core,
 *   you should first look at how Zen core implements those functions:
 *     theme_breadcrumbs()      in zen/template.php
 *     theme_menu_item_link()   in zen/template.php
 *     theme_menu_local_tasks() in zen/template.php
 *
 *   For more information, please visit the Theme Developer's Guide on
 *   Drupal.org: http://drupal.org/node/173880
 *
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *   Each tpl.php template file has several variables which hold various pieces
 *   of content. You can modify those variables (or add new ones) before they
 *   are used in the template files by using preprocess functions.
 *
 *   This makes THEME_preprocess_HOOK() functions the most powerful functions
 *   available to themers.
 *
 *   It works by having one preprocess function for each template file or its
 *   derivatives (called template suggestions). For example:
 *     THEME_preprocess_page    alters the variables for page.tpl.php
 *     THEME_preprocess_node    alters the variables for node.tpl.php or
 *                              for node-forum.tpl.php
 *     THEME_preprocess_comment alters the variables for comment.tpl.php
 *     THEME_preprocess_block   alters the variables for block.tpl.php
 *
 *   For more information on preprocess functions and template suggestions,
 *   please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/node/223440
 *   and http://drupal.org/node/190815#template-suggestions
 */


/**
 * Implementation of HOOK_theme().
 */
function atlanticportal_theme(&$existing, $type, $theme, $path) {
  $hooks = zen_theme($existing, $type, $theme, $path);
  
  $hooks['breadcrumb'] = array(
    'arguments' => array('breadcrumb' => ''),
  );
  
  /* Biblio module theme functions */
  
  $hooks['biblio_entry'] = array(
    'arguments' => array('node' => NULL, 'base' => '', 'style' => '', 'inline' => FALSE),
    'file'      => './' . _atlanticportal_path() . '/overrides/biblio.inc'
  );
  
  $hooks['biblio_export_links'] = array(
    'arguments' => array('node' => NULL),
    'file'      => './' . _atlanticportal_path() . '/overrides/biblio.inc',
  );

  $hooks['biblio_openurl'] = array(
    'arguments' => array('node' => NULL),
    'file'      => './' . _atlanticportal_path() . '/overrides/biblio.inc',
  );
  
  return $hooks;
}

/**
 * Override or insert variables into all templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered (name of the .tpl.php file.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
function atlanticportal_preprocess_page(&$vars, $hook) {
  // Minimal set of language-switcher links uses less space
  // than the Locale-provided Block
  $vars['language_links'] = _atlanticportal_language_links();
  
  // Admin form doesn't allow HTML in footer message. Build a 
  // language-appropriate footer message, and append anything entered
  // via the admin form.
  // @fixme garbage: tags here & in _atlanticportal_footer_message(), messy.
  $footer_message = _atlanticportal_footer_message();
  
  if ($vars['footer_message']) {
    $footer_message .= '<div class="section">'. $vars['footer_message'] .'</div>';
  }
  $vars['footer_message'] = $footer_message;
}


/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function atlanticportal_preprocess_node(&$vars, $hook) {
  // First, preprocessing that applies to all node types
  
  // Better date format
  $vars['date'] = format_date($vars['node']->created, 'custom', 'j F Y');
  
  // Next, run node-type-specific preprocess functions
  // When #341140 is fixed, replace _zen_path() with drupal_get_path().
  $preprocess_file = './' . _atlanticportal_path() . '/preprocess/node-'. $vars['node']->type . '.inc';
  
  if (file_exists($preprocess_file)) {
    include_once $preprocess_file;
    
    $function = __FUNCTION__ . '_' . $vars['node']->type;
    if (function_exists($function)) {
      $function($vars, $hook);
    }
  }
}

/**
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_comment(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_block(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Return a themed breadcrumb trail.  Long page titles, 
 * if displayed in trail, are truncated to a maximum length.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return
 *   A string containing the breadcrumb output.
 */
function atlanticportal_breadcrumb($breadcrumb) {
  // Determine if we are to display the breadcrumb.
  $show_breadcrumb = theme_get_setting('zen_breadcrumb');
  if ($show_breadcrumb == 'yes' || $show_breadcrumb == 'admin' && arg(0) == 'admin') {

    // Optionally get rid of the homepage link.
    $show_breadcrumb_home = theme_get_setting('zen_breadcrumb_home');
    if (!$show_breadcrumb_home) {
      array_shift($breadcrumb);
    }

    // Return the breadcrumb with separators.
    if (!empty($breadcrumb)) {
      $breadcrumb_separator = theme_get_setting('zen_breadcrumb_separator');
      $trailing_separator = $title = '';
      if (theme_get_setting('zen_breadcrumb_title')) {
        if ($title = drupal_get_title()) {
          if (theme_get_setting('atlanticportal_breadcrumb_maxlength')) {
            $title = truncate_utf8($title, theme_get_setting('atlanticportal_breadcrumb_maxlength'), TRUE, TRUE);
          }
          $trailing_separator = $breadcrumb_separator;
        }
      }
      elseif (theme_get_setting('zen_breadcrumb_trailing')) {
        $trailing_separator = $breadcrumb_separator;
      }
      return '<div class="breadcrumb">' . implode($breadcrumb_separator, $breadcrumb) . "$trailing_separator$title</div>";
    }
  }
  // Otherwise, return an empty string.
  return '';
}



/**
 * Restyle the theme-configurable search box
 *
 * @param $vars
 *  An array of variables to pass to the theme template
 */
function atlanticportal_preprocess_search_theme_form(&$vars) {
  // Remove title displayed on textfield mouseover
  unset($vars['form']['search_theme_form']['#attributes']['title']);
  
  // Get a language-appropriate default value for the search box
  $default_text = t('Search');

  // Set the default value:
  $vars['form']['search_theme_form']['#value'] = $default_text;
  
  // .. and add handlers to clear the default on blur/focus
  $vars['form']['search_theme_form']['#attributes'] = array(
    'onblur'  => "clearInput('edit-search-theme-form-1', '$default_text')",
    'onfocus' => "clearInput('edit-search-theme-form-1', '$default_text')",
  );
  
  // Re-render the textfield
  unset($vars['form']['search_theme_form']['#printed']);
  $vars['search']['search_theme_form'] = drupal_render($vars['form']['search_theme_form']);

  // Collect all form elements to print entire form
  $vars['search_form'] = implode($vars['search']);
}

/**
 *  Build & theme language selection links to add to page template.
 *  Derived from locale.inc:local_block($op, $delta)
 *
 * @return string
 *   Themed language links as string.
 */
function _atlanticportal_language_links() {
  // Only build links if we have at least two languages and language dependent
  // web addresses, so we can actually link to other language versions.
  $language_links = '';
  
  if (variable_get('language_count', 1) > 1 && 
      variable_get('language_negotiation', LANGUAGE_NEGOTIATION_NONE) != LANGUAGE_NEGOTIATION_NONE) {
  
    $path = drupal_is_front_page() ? '<front>' : $_GET['q'];
    $languages = language_list('enabled');
    $links = array();
    
    foreach ($languages[1] as $language) {
      $links[$language->language] = array(
        'href'       => $path,
        'title'      => $language->native,
        'language'   => $language,
        'attributes' => array('class' => 'language-link'),
      );
    }

    // Allow modules to provide translations for specific links.
    // A translation link may need to point to a different path or use
    // a translated link text before going through l(), which will just
    // handle the path aliases.
    drupal_alter('translation_link', $links, $path);
    $language_links = theme('links', $links, array('class' => 'links inline'));
  }

  return $language_links;
}

function _atlanticportal_footer_message() {
  $footer_message = '<div class="section">&copy; '. format_date(time(), 'custom', 'Y') . ' ';
  
  $footer_message .= l(t('Atlantic Canada Portal'), '<front>');
  $footer_message .= ' / ';
  $footer_message .= l(t('University of New Brunswick'), 'http://www.unb.ca/') . '. ';
  $footer_message .= t('All rights reserved') .'.</div>';
  
  // @fixme laaaaazy, fix w/ l() and t()
  $footer_message .= '<div class="section credits">Managed with <a href="http://drupal.org/">Drupal</a>. Theme based on <a href="http://www.fireandknowledge.org/archives/2007/09/05/blueprint-wordpress-theme/">Blueprint-WP</a>.</div>';
  
  return $footer_message;
}

/**
 * Returns the path to the Atlantic Portal theme.
 *
 * drupal_get_filename() is broken; see #341140. When that is fixed in Drupal 6,
 * replace _atlanticportal_path() with drupal_get_path('theme', 'atlanticportal').
 *
 * @return string
 */
function _atlanticportal_path() {
  static $path = FALSE;
  if (!$path) {
    $matches = drupal_system_listing('atlanticportal\.info$', 'themes', 'name', 0);
    if (!empty($matches['atlanticportal']->filename)) {
      $path = dirname($matches['atlanticportal']->filename);
    }
  }
  return $path;
}