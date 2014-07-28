<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
require_once 'facebook_api.php';

class Fb extends Facebook_api {
  private $CI = null;

  public function __construct ($config = array ()) {
    $this->CI =& get_instance ();
    parent::__construct (array_merge (array ('appId'  => config ('facebook_config', 'appId'), 'secret' => config ('facebook_config', 'secret')), $config));
  }

  public function fql ($query) {
    return $this->getUser () ? $this->api (array ('method' => 'fql.query', 'query' => $query)) : null;
  }

  public function getLoginUrl ($config = array ()) {
    return parent::getLoginUrl (array_merge (array ('scope'  => config ('facebook_config', 'scope')), $config));
  }
}