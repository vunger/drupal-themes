<?php
/**
 * Customize default theming provided by Biblio module
 */

/**
 * Implementation of theme_biblio_entry
 *
 * @param $node
 * @param $base
 * @param $style
 * @param $inline
 * @return string
 */
function atlanticportal_biblio_entry($node, $base = 'biblio', $style = 'classic', $inline = false) {
  $output  = '<div class="biblio-entry">';

  // first add the styled entry...
  $output .= theme('biblio_style', $node, $base, $style, $inline);
  
  // any annotations?
  $annotation_field = variable_get('biblio_annotations', 'none');
  if ($annotation_field != 'none' && $node-> $annotation_field) {
    $output .= '<div class="biblio-annotation">';
    $output .= check_markup($node->$annotation_field, $node->format, FALSE);
    $output .= '</div>';
  }
  
  // Add link(s) to abstract and full text, if present
  if ($node->biblio_abst_e or $node->body) {
    $option_links .= _biblio_view_links($node);
  }
  
  // Add citation export links
  if (biblio_access('export', $node)) {
    $option_links .= theme('biblio_export_links', $node);
  }

  // Group Google Scholar and OpenURL links
  if (variable_get('biblio_baseopenurl', '')
      || variable_get('biblio_google_link', 1)) {
      $option_links .= _biblio_search_links($node);
  }

  // Add links to attached files, if present
  if (biblio_access('download', $node)) {
    $option_links .= theme('biblio_download_links',$node);
  }

  if (! empty($option_links)) {
    $output .= '<div class="biblio-links">'. $option_links .'</div>';
  }
  
  $output .= '</div>';
  
  return $output;
}


/**
 * Implementation of theme_biblio_export_links
 *
 * @param Node $node
 * @return string
 */
function atlanticportal_biblio_export_links($node = NULL) {
  global $pager_total_items;
  module_load_include('inc', 'biblio', 'biblio_theme');

  $base             = variable_get('biblio_base', 'biblio');
  $show_export_link = variable_get('biblio_export_links', array('tagged' => TRUE, 'xml' => TRUE, 'bibtex' => TRUE));

  $links = '';

  if ($show_export_link['tagged']) {
    $links .= '<li> '. _build_biblio_link($base, $node, 'tagged') .'</li>';
  }
  if ($show_export_link['xml']) {
    $links .= '<li> '. _build_biblio_link($base, $node, 'xml') .'</li>';
  }
  if ($show_export_link['bibtex']) {
    $links .= '<li> '. _build_biblio_link($base, $node, 'bibtex') .'</li>';
  }

  if (! empty($links)) {
      $link_label =
        empty($node) ?
          t('Export @count results', array('@count' => $pager_total_items[0])) :
          t('Export');

      $links = '<ul class="biblio-export-buttons"><li>'. $link_label .':</li>'. $links .'</ul>';
  }

  return $links;
}

/**
 * Implementation of theme_biblio_openurl
 *
 * @param object $node
 * @return string
 */
function atlanticportal_biblio_openurl($node) {

  global $user;
  $openurl_resolver = variable_get('biblio_baseopenurl', '');

  if (isset($user->biblio_baseopenurl)  &&
      !empty($user->biblio_baseopenurl) &&
      variable_get('biblio_show_openurl_profile_form', '1')) {
    $openurl_resolver =  check_plain($user->biblio_baseopenurl);
  }

  $output = '';
  
  if (! $openurl_resolver) {
    return $output;
  }

  // biblio_theme.inc:biblio_openURL runs query parameter values through
  // rawurlencode(), which are then passed to l() in an array -- which 
  // triggers another encoding.  If given a query string, l() assumes
  // the encoding has already been handled.
  $openurl_query = biblio_openURL($node);
  
  $openurl_query_string = '';
  foreach ($openurl_query as $param => $value) {
    $openurl_query_string .= "$param=$value&";
  }
  
  $openurl_image = variable_get('biblio_openurlimage', '');

  if ($openurl_image) {
    $output = l(
      '<img src="'. $openurl_image .'" alt="'. t('OpenURL') .'"/>',   // $text
      $openurl_resolver,                                              // $path
      array(                                                          // $options
        'attributes' => array(
          'class' => 'biblio-openurl-image'
        ),
        'query' => $openurl_query_string,
      )
    );
  }
  else {
    $output = l(
      t('OpenURL'),                           // $text
      $openurl_resolver,                      // $path
      array(                                  // $options
        'attributes' => array(
          'class' => 'biblio-openurl-text'
        ),
        'query' => $openurl_query_string,
      )
    ); 
  }
  
  return $output;
}

/**
 * Local function builds links to search Google Scholar, WorldCat, etc. for
 * current entry.
 *
 * @param $node
 * @return string
 */
function _biblio_search_links($node = NULL) {
  module_load_include('inc', 'biblio', 'biblio_theme');
  $base = variable_get('biblio_base', 'biblio');
  $links = '';

  if (variable_get('biblio_baseopenurl', '')){
    $links .= '<li>' . theme('biblio_openurl', $node) .'</li>';
  }
  if (variable_get('biblio_google_link', 1)) {
    $links .= '<li> '. _build_biblio_link($base, $node, 'google') .'</li>';
  }

  if (!empty($links)) {
    $links = '<ul class="biblio-search-buttons"><li>' . t('Search') . ':</li>'. $links .'</ul>';
  }

  return $links;
}

/**
 * Local function builds links to view abstract and/or full text.
 *
 * @param Node $node
 * @return String
 */
function _biblio_view_links($node = NULL) {
  $links = '';

  if ($node->biblio_abst_e) {
    $links .= '<li>'. l('Abstract', "node/$node->nid") . '</li>';
  }
  if ($node->body && user_access('view full text')) {
    $links .= '<li>'. l('Full Text', "node/$node->nid") . '</li>';
  }

  if (!empty($links)) {
      $links = '<ul class="biblio-view-buttons"><li>'. t('View') .':</li>'. $links .'</ul>';
  }

  return $links;
}