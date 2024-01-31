<?php

namespace DbConnection;

use Exception;
use mysqli;

class DbConnect {

    private $host;
    private $username;
    private $password;
    private $database;

    public function loadEnv() {

        $envPath = __DIR__ . '/.env';

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

    public function connect() {

        $this->loadEnv();

        $conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        } else {

            echo 'Connection Established';
        }

        return $conn;
    }
}

?>
