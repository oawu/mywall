<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */

include_once ('type_helper.php');

if ( !function_exists ('send_post')) {
  function send_post ($url, $params = array (), $is_wait = false, $port = 80, $timeout = 30) {
    $url = parse_url ($url);

    if ($fp = fsockopen ($url['host'], $port, $errno, $errstr, $timeout)) {

      $postdata_str = count ($params) ? http_build_query ($params) : '';

      $request = "POST " . $url['path'] . " HTTP/1.1\r\n" .
                 "Host: " . $url['host'] . "\r\n" .
                 "Content-Type: application/x-www-form-urlencoded\r\n" .
                 "Content-Length: " . strlen ($postdata_str) . "\r\n\r\n" .
                 $postdata_str . "\r\n" .
                 "bye\r\n";

      fwrite ($fp, $request);
      if ($is_wait) while (!feof($fp)) { echo fgets($fp, 128); }
      fclose ($fp);
    }
  }
}

if ( !function_exists ('delay_request')) {
  function delay_request ($class, $method, $params = array ()) {
    if (!verifyString ($class) || !verifyString ($method)) showError ('delay_request class method 傳入參數不正確! 需要 非空字串 缺少!');

    $params = array_merge ($params, array (config ('d4_config', 'delay_request', 'request_code_key') => md5 (config ('d4_config', 'delay_request', 'request_code_value'))));
    
    $url = utilityPath (preg_match_all ("/^(https?:\/\/?)/", $url = config ('d4_config', 'delay_request', 'base_url'), $matches) ? $url : ('http://' . $url)) . '/' . $class . '/' . $method;

    send_post ($url, $params);
  }
}

if ( !function_exists ('post_request')) {
  function post_request ($url, $params = array (), $verb = 'POST') {
    $verb = verifyItemInArray ($verb, array ('POST', 'GET')) ? $verb : 'POST';
    $cparams = array ('http' => array ('method' => $verb, 'ignore_errors' => true));

    if (verifyArray ($params) && verifyString ($params = http_build_query ($params))) {
      if ($verb == 'POST') {
        $cparams['http']['content'] = $params;
        $cparams['http']['header'] = "Content-type: application/x-www-form-urlencoded\r\nContent-Length: " . strlen ($params) . "\r\n";
      } else {
        $url .= '?' . $params;
      }
    }

    $context = stream_context_create ($cparams);
    $fp = fopen ($url, 'rb', false, $context);
    $res = !$fp ? false : stream_get_contents ($fp);
    return ($res === false) || (json_decode ($res) === null) ? null : (string)$res;
  }
}