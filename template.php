<?php
// $Id$

/**
 * @file
 * ETCDrupal customizations of parent theme, 'Sky'
 */

/**
 * Implementation of theme_node_submitted()
 * Removes user name from node submission info
 */

function etcdrupal_node_submitted($node) {
  return t('Posted @datetime',
    array(
      '@datetime' => format_date($node->created),
    ));
}
