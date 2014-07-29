<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('send_post')) {
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

if ( ! function_exists('post_request')) {
  function post_request ($url, $params = null, $verb = 'POST', $format = 'json') {
    
    $cparams = array(
      'http' => array(
        'method' => $verb,
        'ignore_errors' => true
      )
    );

    if ($params !== null) {
      $params = http_build_query ($params);
      if ($verb == 'POST') {
        $cparams['http']['content'] = $params;
        $cparams['http']['header'] = "Content-type: application/x-www-form-urlencoded\r\nContent-Length: " . strlen ($params) . "\r\n";
      }
      else {
        $url .= '?' . $params;
      }
    }

    $context = stream_context_create ($cparams);
    $fp = fopen ($url, 'rb', false, $context);
    if (!$fp) {
      $res = false;
    } else {
      // $meta = stream_get_meta_data($fp);
      // var_dump($meta['wrapper_data']);
      $res = stream_get_contents ($fp);
    }

    if ($res === false) {
      throw new Exception("$verb $url failed: $php_errormsg");
    }

    switch ($format) {
      case 'json':
        $r = json_decode ($res);
        if ($r === null) throw new Exception ("failed to decode $res as json");
        else return $r;

      case 'xml':
        $r = simplexml_load_string ($res);
        if ($r === null) throw new Exception ("failed to decode $res as xml");
        else return $r;
    }
    return $res;
  }
}