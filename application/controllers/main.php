<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Main extends Site_controller {
  public function __construct () {
    parent::__construct ();
  }


  public  function xx () {
    $a = $this->input_get ('a');
    echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
    var_dump ($a);
    exit ();
  }
  public  function pluralize ( $string ) {
      $plural = array(
          '/(quiz)$/i'               => "$1zes",
          '/^(ox)$/i'                => "$1en",
          '/([m|l])ouse$/i'          => "$1ice",
          '/(matr|vert|ind)ix|ex$/i' => "$1ices",
          '/(x|ch|ss|sh)$/i'         => "$1es",
          '/([^aeiouy]|qu)y$/i'      => "$1ies",
          '/(hive)$/i'               => "$1s",
          '/(?:([^f])fe|([lr])f)$/i' => "$1$2ves",
          '/(shea|lea|loa|thie)f$/i' => "$1ves",
          '/sis$/i'                  => "ses",
          '/([ti])um$/i'             => "$1a",
          '/(tomat|potat|ech|her|vet)o$/i'=> "$1oes",
          '/(bu)s$/i'                => "$1ses",
          '/(alias)$/i'              => "$1es",
          '/(octop)us$/i'            => "$1i",
          '/(ax|test)is$/i'          => "$1es",
          '/(us)$/i'                 => "$1es",
          '/s$/i'                    => "s",
          '/$/'                      => "s"
      );

      $irregular = array(
          'move'   => 'moves',
          'foot'   => 'feet',
          'goose'  => 'geese',
          'sex'    => 'sexes',
          'child'  => 'children',
          'man'    => 'men',
          'tooth'  => 'teeth',
          'person' => 'people'
      );

      $uncountable = array(
          'sheep',
          'fish',
          'deer',
          'series',
          'species',
          'money',
          'rice',
          'information',
          'equipment'
      );
      if ( in_array( strtolower( $string ), $uncountable ) )
        return $string;

      foreach ($irregular as $pattern => $result ) {
        $pattern = '/' . $pattern . '$/i';

        if ( preg_match( $pattern, $string ) )
          return preg_replace( $pattern, $result, $string);
      }

      foreach ( $plural as $pattern => $result ) {
        if ( preg_match( $pattern, $string ) )
          return preg_replace( $pattern, $result, $string );
      }
      return $string;
    }

  public function sqlxml_2_erdxml () {
    $file_path = FCPATH . 'resource/fgplay_rails_2014-09-02.xml';
    $save_file_path = FCPATH . 'resource/a.xml';

    $this->load->helper('file');
    $content = read_file ($file_path);
    preg_match_all ("/\<table_structure[^>]*>(.*?)\<\/table_structure\>/s", $content, $tables);
    $tables = $tables[0];

    if (count ($tables)) {
      $table_list = array();
      foreach ($tables as $table) {
        preg_match_all ("/\<table_structure name=\"(.*?)\"/s", $table, $name);
        $name = $name[1][0];

        preg_match_all ("/\<field(.*?)\/>/s", $table, $fields);
        $fields = $fields[1];

        if (count ($fields)) {
          $row  = array ();
          $pris = array ();
          $muls = array ();
          $unis = array ();

          foreach ($fields as $field) {
            preg_match_all ("/field=\"(.*?)\"/s", $field, $row_name);
            $row_name = $row_name[1][0];

            preg_match_all ("/type=\"(.*?)\"/s", $field, $row_type);
            $row_type = $row_type[1][0];
            
            preg_match_all ("/null=\"(.*?)\"/s", $field, $row_null);
            $row_null = $row_null[1][0];
            
            preg_match_all ("/key=\"(.*?)\"/s", $field, $row_key);
            $row_key = $row_key[1][0];
            
            preg_match_all ("/default=\"(.*?)\"/s", $field, $row_default);
            $row_default = $row_default[1][0];

            preg_match_all ("/extra=\"(.*?)\"/s", $field, $row_extra);
            $row_extra = $row_extra[1][0];

            $row[] = array (
              'name'    => $row_name,
              'type'    => $row_type,
              'null'    => $row_null,
              'key'     => $row_key,
              'default' => $row_default,
              'extra'   => $row_extra,
              );
            if ($row_key == 'PRI') {
              $pris[] = $row_name;
            }

            if ($row_key == 'MUL') {
              $muls[] = $row_name;
            }

            if ($row_key == 'UNI') {
              $unis[] = $row_name;
            }
          }
        }
        $table_list [] = array (
                          'name' => $name,
                          'rows' => $row,
                          'pris' => $pris,
                          'muls' => $muls,
                          'unis' => $unis);
      }
    }
    if (count ($table_list)) {
      $content = '';
      $content .= '<?xml version="1.0" encoding="utf-8" ?>';
      $content .= '<sql>';
      $i = -50;
      foreach ($table_list as $table) {
        $content .= '<table x="0" y="' . ($i+=30) . '" name="' . $table['name'] . '">';

        if (count ($table['rows'])) {
          foreach ($table['rows'] as $row) {
            $content .= '<row name="' . $row['name'] . '" null="' . ($row['null']=='NO'?'0':'1') . '" autoincrement="' . ($row['extra']=='auto_increment'?'1':'0') . '">';
            $content .= '<datatype>' . strtoupper ($row['type']) . '</datatype>';
            $content .= '<default>' . ($row['default']=='<null>'?'NULL':$row['default']) . '</default>';
            if (($temp = substr($row['name'], 0, strrpos ($row['name'], '_id'))) && ($temp = $this->pluralize ($temp)))
              $content .= '<relation table="' . $temp . '" row="id" />';
            $content .= '</row>';
          }
        }

        if (count($table['pris'])) {
          $content .= '<key type="PRIMARY" name="">';
          foreach ($table['pris'] as $pri) {
            $content .= '<part>' . $pri . '</part>';
          }
          $content .= '</key>';
        }

        if (count($table['muls'])) {
          $content .= '<key type="INDEX" name="">';
          foreach ($table['muls'] as $mul) {
            $content .= '<part>' . $mul . '</part>';
          }
          $content .= '</key>';
        }

        if (count($table['unis'])) {
          $content .= '<key type="UNIQUE" name="">';
          foreach ($table['unis'] as $uni) {
            $content .= '<part>' . $uni . '</part>';
          }
          $content .= '</key>';
        }
        $content .= '</table>';
      }
      $content .= '</sql>';
    }
    write_file($save_file_path, $content, 'w+');
  }
  public function index () {
    $this->load_view ();
  }
}
