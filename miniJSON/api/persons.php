<?php

/**
 * miniJSON
 * - a very super simple, basic json php framework.
 *
 * Persons API
 */
class persons
{
    public function __construct()
    {
    }

    public static function get($PersonID=false)
    {
        $sqlite = new sqlite();

      if($PersonID){
        $data['persons'] = $sqlite->query('SELECT * FROM persons WHERE PersonID = :PersonID', array(':PersonID' => $PersonID));
      } else {
        $data['persons'] = $sqlite->query('SELECT * FROM persons');
      }
        return $data;
    }

    public static function put()
    {
        $input = json_decode(file_get_contents('php://input'));

        $sqlite = new sqlite();

        // Check if username already exists
        $user = $sqlite->query('SELECT Username FROM persons WHERE Username = :username ',
                                    array(':username' => $input->username));

        // If it doesn't...
        if(!$user) {

          $statement = 'INSERT INTO persons (Name, Email, Type)
                                    values (:Name, :Email, :Type)';

          $parameters = array(
              ':Name' => $input->Name,
              ':Email' => $input->Email,
              ':Type' => $input->Type
          );

          $sqlite->debug = false;
          $sqlite->exec($statement, $parameters);

          $return['result'] = 'OK';
          return $return;

        // If it does..
        } else {
          $return['result'] = 'Username already exists';
          return $return;
        }
    }

    public static function update()
    {

        $input = json_decode(file_get_contents('php://input'));

        $parameters = Array();
        $fields = "";

        foreach ($input as $k=>$v){
            if($k != 'username' && $k != 'token' && $k != 'PersonID'){
                $parameters[$k] = $v;
                $fields .= "$k = :$k,";
            }
        }

        // debug
        error_log(implode(";", $parameters), 0);

        $parameters[':PersonID'] = $input->PersonID;

        $statement = 'UPDATE persons SET ' . rtrim($fields, ',') . ' WHERE PersonID = :PersonID';

        $sqlite = new sqlite();

        return $sqlite->exec($statement, $parameters);

    }

    public static function delete()
    {
        $input = json_decode(file_get_contents('php://input'));

        $statement = 'DELETE FROM persons WHERE PersonID = :PersonID';

        $parameters = array(
            ':PersonID' => $input->PersonID,
        );

        $sqlite = new sqlite();

        return $sqlite->exec($statement, $parameters);
    }


}
