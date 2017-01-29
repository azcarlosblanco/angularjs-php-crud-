<?php

/**
 * miniJSON
 * - a very super simple, basic json php framework.
 *
 * App
 */
class app
{
    public function __construct()
    {
        spl_autoload_register('App::autoloader');
    }

    public static function autoloader($classname)
    {

        // Search for class
        switch ($classname) {
            case file_exists('api/'.$classname.'.php'):
                $filename = 'api/'.$classname.'.php';
                break;
            case file_exists($classname.'.php'):
                $filename = $classname.'.php';
                break;
            default:
                die('Class '.$classname.' not found.');
                break;
        }

        // Include class
        include_once $filename;
    }

    public function response($content, $status = '200')
    {

        // Responses
        $response = array(
            200 => 'Success',
            401 => 'Authentication Failed',
            404 => 'Invalid Request',
        );

        // Return error response when status not 200
        if ($status != 200) {
            $content = $response[$status];
        }

        // Headers
        header('HTTP/1.1 '.$status.' '.$response[$status]);
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        header('X-Powered-By: miniJSON');

        // Echo response
        echo json_encode($content);
    }

    public function valid_token()
    {

        // Get input
        $input = json_decode(file_get_contents('php://input'));

        // Run SQL
        $sqlite = new sqlite();

        // Validate
        $validated = $sqlite->query('SELECT * FROM tokens WHERE username = :username and token = :token',
                                     array('username' => $input->username, 'token' => $input->token));

        // If validated
        if ($validated) {
            return true;
        } else {
            return false;
        }
    }
}
