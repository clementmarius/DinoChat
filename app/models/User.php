<?php
namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;


class User {

    public function register($pseudo, $email, $password ) {
        $db = Database::getInstance();
        var_dump($db);

        try {
            // Hash du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insertion dans la base de données
            $stmt = $db->prepare("
                INSERT INTO users ( email, pseudo, password)
                VALUES (:email, :pseudo, :password)
            ");

            $stmt->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Erreur SQL : " . $e->getMessage());
            return "Erreur SQL : " . $e->getMessage(); // Retourner l'erreur pour débogage
        }
    }

    public function authenticate($email, $password) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    public function searchUsersByName($query) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT id, pseudo FROM users WHERE pseudo LIKE ? LIMIT 10");
        $stmt->execute(["%$query%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    
}
