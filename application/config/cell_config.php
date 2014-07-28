<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
$cell_config['is_enabled'] = true;

$cell_config['cache_folder']      = APPPATH . 'cell' . DIRECTORY_SEPARATOR . 'cell_cache' . DIRECTORY_SEPARATOR;
$cell_config['controller_folder'] = APPPATH . 'cell' . DIRECTORY_SEPARATOR . 'cell_controllers' . DIRECTORY_SEPARATOR;
$cell_config['view_folder']       = APPPATH . 'cell' . DIRECTORY_SEPARATOR . 'cell_views' . DIRECTORY_SEPARATOR;

$cell_config['d4_time'] = 60;
$cell_config['class_suffix'] = '_cells';
$cell_config['method_prefix'] = '_cache_';
$cell_config['file_prefix'] = '_cell';