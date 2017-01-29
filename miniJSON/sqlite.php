<?php

/**
 * miniJSON
 * - a very super simple, basic json php framework.
 *
 * sqlite helper
 */
class sqlite
{
    public $db;
    public $debug;

    public function __construct()
    {
        $this->db = new PDO('sqlite:db/api.db');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //PDO::ERRMODE_EXCEPTION,
    }

    public function exec($statement, $parameters = array())
    {
        try {
            $st = $this->db->prepare($statement);
            $st->execute($parameters);

            if($this->debug){
              echo PdoDebugger::show($statement, $parameters);
            }

        } catch (PDOException $e) {
            return '<pre>'.$e->getMessage();
        }
    }

    public function query($statement, $parameters = array())
    {
        try {
            $st = $this->db->prepare($statement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $st->execute($parameters);

            return $st->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $e) {
            return '<pre>'.$e->getMessage();
        }
    }

}
