<?php
/**
 * miniJSON
 * - a very super simple, basic json php framework.
 */
class liteman
{
    public function __construct()
    {
    }

    public function tables()
    {
      $sqlite = new sqlite();
      return json_encode($sqlite->query("SELECT name FROM sqlite_master WHERE type='table'"));
    }

    public function pragma($table)
    {
      $sqlite = new sqlite();
      return json_encode($sqlite->query("PRAGMA table_info($table)"));
    }

    public function records($table)
    {
      $sqlite = new sqlite();
      return json_encode($sqlite->query('SELECT * FROM ' . $table));
    }

    public function pk($table)
    {
      $sqlite = new sqlite();
      $pragma = $sqlite->query("PRAGMA table_info($table)");
      foreach($pragma as $k => $v){
        if($v->pk == 1){
          $pk = $v->name;
        }
      }
      return $pk;
    }

    public function update()
    {

        $input = json_decode(file_get_contents('php://input'));

        $parameters = Array();
        $fields = "";
        $key = $input->key;
        $id = $input->id;

        foreach ($input as $k=>$v){
            if($k != 'username' && $k != 'token' && $k != 'key' && $k != $key && $k != 'table' && $k != 'id'){
                $parameters[$k] = $v;
                $fields .= "$k = :$k, ";
            }
        }

        $statement = "UPDATE tasks SET " . rtrim($fields, ', ') . " WHERE $key = $id";
        $sqlite = new sqlite();
        return $sqlite->exec($statement, $parameters);

    }

    public function delete()
    {
      $input = json_decode(file_get_contents('php://input'));

      $parameters = Array();
      $table = $input->table;
      $pk = $input->pk;
      $id = $input->key;

      $statement = "DELETE FROM $table WHERE $pk = $id";
      $sqlite = new sqlite();
      return $sqlite->exec($statement, $parameters);

    }

}
