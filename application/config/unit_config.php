<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
$unit_config['comment']['d4_length']   = 3;
$unit_config['comment']['load_length'] = 2;

$unit_config['id']['main_tags_max_length'] = 9;
$unit_config['id']['more_tags_max_length'] = 5;
$unit_config['id']['more_tag_units_max_length'] = 9;
$unit_config['id']['pictures']['max_count'] = 4;

$unit_config['recommend']['name_max_length']         = 50;
$unit_config['recommend']['introduction_max_length'] = 5000;
$unit_config['recommend']['open_time_max_length']    = 250;
$unit_config['recommend']['address_max_length']      = 250;

$unit_config['recommend']['upload_picture']['format_1s'] = array ('jpg', 'jpeg');
$unit_config['recommend']['upload_picture']['format_2s'] = array ('image/jpeg', 'image/jpg');
$unit_config['recommend']['upload_picture']['max_size']  = 10 * 1024 * 1024;

$unit_config['status']['verifying']  = '待確認';
$unit_config['status']['certified']  = '已通過';
$unit_config['status']['illicitly']  = '未通過';
