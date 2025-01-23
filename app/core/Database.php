<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    // Instance unique de la connexion PDO
    private static $instance = null;

    // Retourne l'instance PDO unique, connexion à la base de données
    public static function getInstance()
    {
        if (self::$instance === null) {
            $servername = "localhost";
            $dbname = "dino";
            $username = "root";
            $password = "";

            try {
                self::$instance = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "Connected successfully";
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }

        return self::$instance;
    }
}
