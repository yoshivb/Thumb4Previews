<?php

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

function plugin_install()
{
  include(dirname(__FILE__).'/config_default.inc.php');

  $query = '
INSERT INTO ' . CONFIG_TABLE . ' (param,value,comment)
VALUES ("Thumb4Previews" , "'.addslashes(serialize($config_default)).'" , "Thumb4Previews plugin parameters");';
  pwg_query($query);
}

function plugin_uninstall()
{
  if (is_dir(PHPWG_ROOT_PATH.PWG_LOCAL_DIR.'Thumb4Previews'))
  {
    gtdeltree(PHPWG_ROOT_PATH.PWG_LOCAL_DIR.'Thumb4Previews');
  }
  
  $query = 'DELETE FROM ' . CONFIG_TABLE . ' WHERE param="Thumb4Previews" LIMIT 1;';
  pwg_query($query);
}

function plugin_activate($plugin_id, $version)
{
  if (is_dir(PHPWG_ROOT_PATH.PWG_LOCAL_DIR.'Thumb4Previews'))
  {
    gtdeltree(PHPWG_ROOT_PATH.PWG_LOCAL_DIR.'Thumb4Previews');
  }
}

function gtdeltree($path)
{
  if (is_dir($path))
  {
    $fh = opendir($path);
    while ($file = readdir($fh))
    {
      if ($file != '.' and $file != '..')
      {
        $pathfile = $path . '/' . $file;
        if (is_dir($pathfile))
        {
          gtdeltree($pathfile);
        }
        else
        {
          @unlink($pathfile);
        }
      }
    }
    closedir($fh);
    return @rmdir($path);
  }
}

?>