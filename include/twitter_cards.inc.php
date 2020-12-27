<?php
/*
Version: 1.0
Plugin Name: Thumb4Previews
Author: yoshivb
Description: Exposes a thumbnail URL to the header template to be used for Twitter Cards for example.
*/

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

// Try using Extended Descriptions to sanitize multi-lingual description tag.
if (defined('EXTENDED_DESC_PATH'))
    include_once(EXTENDED_DESC_PATH . 'include/events.inc.php');

function add_thumb_to_header()
{
  global $user, $page, $template, $conf;
  if(isset($page['image_id']))
  {
    $image_id = $page['image_id'];
  }
  elseif(isset($page['category']))
  {
    $query = '
    SELECT
        representative_picture_id, 
        user_representative_picture_id
      FROM '.CATEGORIES_TABLE.'
        INNER JOIN '.USER_CACHE_CATEGORIES_TABLE.'
        ON id = cat_id
        AND user_id = '.$user['id'].'
    WHERE id_uppercat = '.$page['category']['id'].'
        OR id = '.$page['category']['id'];

    $query.= '
          '.get_sql_condition_FandF(
            array('visible_categories' => 'id'),
            'AND'
            );

    $result = pwg_query($query);

    while ($row = pwg_db_fetch_assoc($result))
    {
      if (!empty($row['user_representative_picture_id']))
      {
        $image_id = $row['user_representative_picture_id'];
      }
      elseif (!empty($row['representative_picture_id']))
      { // if a representative picture is set, it has priority
        $image_id = $row['representative_picture_id'];
      }
    }
  }

  if(isset($image_id))
  {
    $query = '
  SELECT *
    FROM '.IMAGES_TABLE.'
    WHERE id = '.$image_id;

    $result = pwg_query($query);

    while($row = pwg_db_fetch_assoc($result))
    {
      $page_image_url = 'https://' . $_SERVER['HTTP_HOST'] . '/' . DerivativeImage::url(IMG_LARGE, $row);
    }
  }
  
  if(isset($page_image_url))
  {
    $template->assign('PAGE_THUMB', $page_image_url);
  }
  $template->assign('TWITTER_SITE', $conf['Thumb4Previews']['twitter_site']);
}
