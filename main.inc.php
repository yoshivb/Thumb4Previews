<?php
/*
Version: 1.0
Plugin Name: Thumb4Previews
Author: yoshivb
Description: Exposes a thumbnail URL to the header template to be used for Twitter Cards for example.
*/

global $conf;
$conf['Thumb4Previews'] = unserialize($conf['Thumb4Previews']);

// Check whether we are indeed included by Piwigo.
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

define('SKELETON_PATH', PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');

include_once(SKELETON_PATH . '/' . 'include/twitter_cards.inc.php');

add_event_handler('loc_end_page_header', 'add_thumb_to_header');
add_event_handler('get_admin_plugin_menu_links', 'add_admin_menu');

function add_admin_menu($menu)
{
  array_push($menu,
    array(
      'NAME' => 'Thumb4Previews',
      'URL' => get_root_url().'admin.php?page=plugin-'.basename(dirname(__FILE__)),
    )
  );
  return $menu;
}
?>
