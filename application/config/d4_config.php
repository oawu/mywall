<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
// ModelUploader d4_options
$d4_config['model_uploader']['absolute_path']         = FCPATH;
$d4_config['model_uploader']['base_path']             = 'upload'; // FCPATH/upload/
$d4_config['model_uploader']['separate_symbol']       = '_';
$d4_config['model_uploader']['save_original']         = false;
$d4_config['model_uploader']['auto_create_save_path'] = true;
$d4_config['model_uploader']['auto_add_file_format']  = true;
$d4_config['model_uploader']['base_url']              = base_url ();
$d4_config['model_uploader']['image_utility_class']   = 'gd';


// WebStreamUtility d4_options
$d4_config['web_stream_utility']['time_limit']    = 30;
$d4_config['web_stream_utility']['temp_folder']   = sys_get_temp_dir ();
$d4_config['web_stream_utility']['temp_prefix']   = 'WSU_';
$d4_config['web_stream_utility']['save_path']     = 'temp'; // FCPATH/temp/
$d4_config['web_stream_utility']['absolute_path'] = FCPATH;

// http => http://xxx.xxx.xxx...
$d4_config['delay_request']['base_url'] = base_url (array ('delay'));
$d4_config['delay_request']['request_code_key'] = 'dr_key';
$d4_config['delay_request']['request_code_value'] = 'D SA!#refsd`13F';



// Minute
$d4_config['static_page_cache_time'] = 60;

// Minute
$d4_config['dynamic_page_cache_time'] = 10;

$d4_config['unit']['picture_url'] = 'http://ibeautywww.s3.amazonaws.com/uploads/share/picture/743147/w800_share_picture_538699d3245c1.jpg';

