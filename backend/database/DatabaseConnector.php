<?php

class DatabaseConnector {

    private $dbConnection = null;

    public function __construct() 
    {
        $env = parse_ini_file('.env');

        $host = $env['DB_HOST'];
        $db = $env['DB_DATABASE'];
        $user = $env['DB_USERNAME'];
        $password = $env['DB_PASSWORD'];

        try {
            $this->dbConnection = new PDO("mysql:host=$host;dbname=$db", $user, $password);
        } catch(PDOException $e) {
                exit($e->getMessage());
        }
    }

    public function getConnection() 
    {
        return $this->dbConnection;
    }
}

?>