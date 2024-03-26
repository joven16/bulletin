<?php

class DBConnection
{
    public static function connect()
    {
        if (!function_exists('loadEnv')) {
            // Function to parse .env file and retrieve values
            function loadEnv($path)
            {
                $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ($lines as $line) {
                    if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                        list($key, $value) = explode('=', $line, 2);
                        $key = trim($key);
                        $value = trim($value);
                        $_ENV[$key] = $value;
                    }
                }
            }
        }

        // Load environment variables from .env file
        loadEnv(__DIR__ . '/../.env');

        // Database connection parameters
        $dbHost = $_ENV['DB_HOST'];
        $dbPort = $_ENV['DB_PORT'];
        $dbDatabase = $_ENV['DB_DATABASE'];
        $dbUsername = $_ENV['DB_USERNAME'];
        $dbPassword = $_ENV['DB_PASSWORD'];

        // Create PDO instance
        $dsn = "mysql:host=$dbHost;port=$dbPort;dbname=$dbDatabase";
        $pdo = new PDO($dsn, $dbUsername, $dbPassword);

        return $pdo;
    }
}