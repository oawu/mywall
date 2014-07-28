<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */

$search_config['is_use'] = true;
$search_config['ip']     = "54.250.187.141";
$search_config['port']   = "9200";
$search_config['index']  = "style_2";

$search_config['types']['share']         = 'style_2_shares';
$search_config['types']['share_keyword'] = 'style_2_share_keywords';
$search_config['types']['user']          = 'style_2_users';
$search_config['types']['page_view']     = 'style_2_page_view';

$search_config['mappings'][$search_config['types']['share']] = array (
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

$search_config['mappings'][$search_config['types']['share_keyword']] = array (
    'id'   => array ('type' => 'string'),
    'name' => array ('type' => 'string')
  );

$search_config['mappings'][$search_config['types']['user']] = array (
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

$search_config['mappings'][$search_config['types']['page_view']] = array (
    'id'        => array ('type' => 'string'),
    'object'    => array ('type' => 'string'),
    'object_id' => array ('type' => 'integer'),
    'location'  => array ('type' => 'string'),
    'value'     => array ('type' => 'integer'),
    'date'      => array ('type' => 'string')
  );