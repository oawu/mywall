<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */

$config['is_use'] = true;
$config['ip']     = "54.250.187.141";
$config['port']   = "9200";
$config['index']  = array ();

$config['types']['share']         = 'style_shares';
$config['types']['share_keyword'] = 'style_share_keywords';
$config['types']['user']          = 'style_users';
$config['types']['page_view']     = 'style_page_view';

$config['mappings'][$config['types']['share']] = array (
    'id'                => array ('type' => 'integer', 'index' => 'not_analyzed'),
    'user_id'           => array ('type' => 'integer'),
    'text'              => array ('type' => 'string'),
    'link_title'        => array ('type' => 'string'),
    'share_likes_count' => array ('type' => 'integer'),
    'year_week'         => array ('type' => 'integer'),
    'pv'                => array ('type' => 'integer'),
    'upload_from'       => array ('type' => 'string'),
    'country'           => array ('type' => 'string'),
    'keywords'          => array ('type' => 'string'),
    'category_name'     => array ('type' => 'string'),
    'user_name'         => array ('type' => 'string')
  );

$config['mappings'][$config['types']['share_keyword']] = array (
    'id'   => array ('type' => 'string'),
    'name' => array ('type' => 'string')
  );

$config['mappings'][$config['types']['user']] = array (
    'id'           => array ('type' => 'integer'),
    'name'         => array ('type' => 'string'),
    'email'        => array ('type' => 'string'),
    'oauth_from'   => array ('type' => 'string'),
    'country'      => array ('type' => 'string'),
    'avatar_big_url'    => array ('type' => 'string'),
    'avatar_middle_url' => array ('type' => 'string'),
    'avatar_small_url'  => array ('type' => 'string'),
    'shares_count'       => array ('type' => 'integer'),
    'share_likes_count'  => array ('type' => 'integer'),
    'share_likeds_count' => array ('type' => 'integer'),
    'share_comments_count'   => array ('type' => 'integer'),
    'share_commenteds_count' => array ('type' => 'integer'),
    'share_sum_pv'       => array ('type' => 'integer'),
    'share_average_pv'   => array ('type' => 'float'),
  );

$config['mappings'][$config['types']['page_view']] = array (
    'id'        => array ('type' => 'string'),
    'object'    => array ('type' => 'string'),
    'object_id' => array ('type' => 'integer'),
    'location'  => array ('type' => 'string'),
    'value'     => array ('type' => 'integer'),
    'date'      => array ('type' => 'string')
  );