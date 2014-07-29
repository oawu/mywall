<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */

$model_config['recycle']['limit'] = 100;
$model_config['recycle']['origin_id'] = 'origin_id';

$model_config['uploader']['temp_directory'] = FCPATH . 'temp' . DIRECTORY_SEPARATOR;
$model_config['uploader']['temp_file_name'] = uniqid (rand () . '_');

$model_config['uploader']['file_name']['separate_symbol'] = '_';
$model_config['uploader']['file_name']['auto_add_format'] = true;

$model_config['uploader']['instances']['directory'] = FCPATH . APPPATH . 'third_party' . DIRECTORY_SEPARATOR . 'orm_image_uploaders' . DIRECTORY_SEPARATOR;
$model_config['uploader']['instances']['class_suffix'] = 'Uploader';

$model_config['uploader']['default_version'] = array ('' => array ());
$model_config['uploader']['bucket']['type'] = 'local';
$model_config['uploader']['bucket']['local']['base_directory'] = 'upload' . DIRECTORY_SEPARATOR;
