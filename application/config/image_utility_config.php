<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */

// gd、imgk
$image_utility_config['module'] = 'gd';
$image_utility_config['modules'] = array ('gd'   => 'ImageGdUtility',
                                          'imgk' => 'ImageImagickUtility');

$image_utility_config['gd']['allow_formats'] = array ('gif', 'jpg', 'png');
$image_utility_config['gd']['mime_formats'] = array ( 'image/gif'   => 'gif',
                                                      'image/jpeg'  => 'jpg',
                                                      'image/pjpeg' => 'jpg',
                                                      'image/png'   => 'png',
                                                      'image/x-png' => 'png');

$image_utility_config['imgk']['allow_formats'] = array ('gif', 'jpg', 'png');
$image_utility_config['imgk']['mime_formats'] = array ( 'image/gif'   => 'gif',
                                                        'image/jpeg'  => 'jpg',
                                                        'image/pjpeg' => 'jpg',
                                                        'image/png'   => 'png',
                                                        'image/x-png' => 'png');
