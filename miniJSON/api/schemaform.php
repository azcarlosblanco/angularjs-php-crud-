<?php
/**
 * miniJSON
 * - a very super simple, basic json php framework.
 * JSON for angular-schema-form
 */
class schemaform
{
    public function __construct()
    {
    }
    public function schema($table)
    {
      $sqlite = new sqlite();
      $pragma = $sqlite->query("PRAGMA table_info($table) ");
      $json['type'] = 'object';
      $json['title'] = $table;
      foreach($pragma as $k => $v){
        if($v->name != 'timestamp'){
          $fields[$v->name]['type'] = 'string';
          $fields[$v->name]['title'] = $v->name;
          // todo translate datatypes to angular-schema-form-types
        }
      }
      $json['properties'] = $fields;
      return $json;
    }
    public function form($table)
    {
      $sqlite = new sqlite();
      $pragma = $sqlite->query("PRAGMA table_info($table) ");
      foreach($pragma as $k => $v){
        if($v->name != 'timestamp'){
          $json[] = $v->name;
        }
      }

      return $json;
    }
    public function data(){
      $input = json_decode(file_get_contents('php://input'));
      $sqlite = new sqlite();
      return $sqlite->query("select * from $input->table where $input->key = $input->id");
    }
}
