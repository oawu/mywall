<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */

if ( !function_exists ('make_click_able_links')) {
  function make_click_able_links ($text, $is_new_page = true, $class = '', $link_text = '', $max_count_use_link_text = 0) {
    $text = " " .  ($text);
    return preg_replace ('/(((https?:\/\/)[~\S]+))/', '<a href="${1}"' . (isset ($class) && ($class != null) && is_string ($class) && ($class != '') ? (' class="' . $class . '"') : '') . '' . ($is_new_page ? ' target="_blank"' : '') . '>' . (isset ($link_text) && ($link_text != null) && is_string ($link_text) && ($link_text != '') ? $link_text : '${1}') . '</a>', $text);
  }
}