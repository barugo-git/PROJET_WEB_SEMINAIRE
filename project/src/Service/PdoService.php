<?php

namespace App\Service;

use PDO;
use PDOException;

class PdoService
{
    private $pdo;

    public function __construct(string $dbHost, string $dbName, string $dbUser, string $dbPass)
    {
        // Source de données DSN
        $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";
        
        // Options de la connexion PDO
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        
            PDO::ATTR_EMULATE_PREPARES   => false,                   
        ];

        try {
            $this->pdo = new PDO($dsn, $dbUser, $dbPass, $options);
        } catch (PDOException $e) {
            // Gestion des erreurs avec message détaillé en mode dev
            if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
                echo "<h1>Erreur de connexion à la base de données</h1>";
                echo "<p>Détails : " . htmlspecialchars($e->getMessage()) . "</p>";
            }
            exit();
        }
    }

    // Méthode pour obtenir la connexion PDO
    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
