<?php

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

global $template, $conf, $page;

include(dirname(__FILE__).'/config_default.inc.php');
$params = $conf['Thumb4Previews'];

// Save configuration
if (isset($_POST['submit']))
{
  $params  = array(
    'twitter_site'          => $_POST['twitter_site'],
  );

  if (substr( $params['twitter_site'], 0, 1 ) !== "@")
  {
    array_push($page['errors'], 'Twitter site is a twitter handle so has to start with @.');
  }

  if (empty($page['errors']))
  {
    $query = '
  UPDATE ' . CONFIG_TABLE . '
    SET value="' . addslashes(serialize($params)) . '"
    WHERE param="Thumb4Previews"
    LIMIT 1';
    pwg_query($query);
    
    array_push($page['infos'], l10n('Information data registered in database'));
  }
}

// Configuration du template
$template->assign(
  array(
    'TWITTER_SITE'    => $params['twitter_site'],
    'PWG_TOKEN'       => get_pwg_token(),
  )
);

$template->set_filenames(array('plugin_admin_content' => dirname(__FILE__) . '/template/admin.tpl'));
$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');

?>