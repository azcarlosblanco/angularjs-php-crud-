<?php

/**
 * miniJSON
 * - a very super simple, basic json php framework.
 *
 * Users API
 */
class users
{
    public function __construct()
    {
    }

    public static function get()
    {
        $sqlite = new sqlite();
        $data['users'] = $sqlite->query('SELECT * FROM users');

        return $data;
    }

    public static function put()
    {
        $input = json_decode(file_get_contents('php://input'));

        $sqlite = new sqlite();

        // Check if username already exists
        $user = $sqlite->query('SELECT Username FROM users WHERE Username = :username ',
                                    array(':username' => $input->username));

        // If it doesn't...
        if(!$user) {

          $statement = 'INSERT INTO users (Username, Password)
                                    values (:username, :password)';

          $parameters = array(
              ':username' => $input->username,
              ':password' => $input->password,
          );

          $sqlite->exec($statement, $parameters);

          $return['result'] = 'OK';
          return $return;

        // If it does..
        } else {
          $return['result'] = 'Username already exists';
          return $return;
        }
    }

    public static function create_table()
    {
        $sqlite = new sqlite();

        return $sqlite->exec("
            create table users (
            UserId INTEGER PRIMARY KEY,
            Username varchar(255) NULL DEFAULT '',
            Password  varchar(255) NULL DEFAULT ''
            )
        ");
    }
}
