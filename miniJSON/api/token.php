<?php

/**
 * miniJSON
 * - a very super simple, basic json php framework.
 *
 * Tokens API
 */
class token
{
    public function __construct()
    {
    }

    public static function get()
    {
        $input = json_decode(file_get_contents('php://input'));

        // Debug
        //error_log($input->username, 0);
        //error_log($input->password, 0);

        $sqlite = new sqlite();

        // TODO: encrypt password
        $validated = $sqlite->query('SELECT * FROM users WHERE Username = :username and Password = :password ',
                                    array(':username' => $input->username, ':password' => $input->password));

        // If validated
        if ($validated) {

            // Delete previous tokens
            $statement = 'DELETE FROM tokens WHERE username = :username';

            $parameters = array(
                ':username' => $input->username
            );

            $sqlite->exec($statement, $parameters);

            // Create and add new token
            $token['token'] = bin2hex(openssl_random_pseudo_bytes(16));

            $statement = 'INSERT INTO tokens (username, token)
                                      values (:username, :token)';

            $parameters = array(
                ':username' => $input->username,
                ':token' => $token['token'],
            );

            $sqlite->exec($statement, $parameters);

            // Return token
            return array('result' => 'OK','username' => $input->username,'token' => $token['token']);

        } else {

            return array('result' => 'Username and/or password incorrect, please try again. ' . implode(";", $input));

        }

    }

    public static function destroy()
    {
        $input = json_decode(file_get_contents('php://input'));

        $sqlite = new sqlite();

        $sqlite->exec('DELETE FROM tokens where username = :username and token = :token',
                       array(':username' => $input->username, ':token' => $input->token));

        return array('username' => $input->username, 'token' => $input->token, true);
    }

    public static function create_table()
    {
        $sqlite = new sqlite();

        return $sqlite->exec("
            create table tokens (
            tokenid   INTEGER PRIMARY KEY,
            username  varchar(255) NULL DEFAULT '',
            token     varchar(255) NULL DEFAULT '',
            timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
            )
        ");
    }
}
