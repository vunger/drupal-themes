<?php

function atlanticportal_preprocess_node_biblio(&$vars, $hook) {
  // Re-create the node view links to be consistent with Biblio view.
  unset($vars['links']);
  $links = '';

  // Citation export links
  if (biblio_access('export', $node)) {
    $links .= theme('biblio_export_links', $node);
  }

  // Group Google Scholar and OpenURL links
  if (variable_get('biblio_baseopenurl', '')
      || variable_get('biblio_google_link', 1)) {
      $links .= _biblio_search_links($node);
  }

  // Add links to attached files, if present
  if (biblio_access('download', $node)) {
    $links .= theme('biblio_download_links',$node);
  }

  if ($links) {
    $vars['links'] .= '<div class="biblio-links">'. $links . '</div>';
  }
}