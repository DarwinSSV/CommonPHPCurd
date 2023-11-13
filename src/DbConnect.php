<?php

class DbConnect {
    private $host;
    private $username;
    private $password;
    private $database;

    public function __construct() {
        $this->loadEnv();
        $this->connect();
    }

    private function loadEnv() {
        $envPath = getcwd() . '/.env';
         
        if (!file_exists($envPath)) {
            throw new Exception('.env file not found.');
        }

        $env = parse_ini_file($envPath);

        if (!$env) {
            throw new Exception('Error parsing .env file.');
        }

        $this->host = $env['DB_HOST'];
        $this->username = $env['DB_USER'];
        $this->password = $env['DB_PASSWORD'];
        $this->database = $env['DB_DATABASE'];
    }

    private function connect() {
        $conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        return $conn;
    }
}

?>
