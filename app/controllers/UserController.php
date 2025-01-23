<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use Exception;


class UserController extends Controller
{

    // Affiche la page de connexion
    public function index()
    {
        $this->view('user/login');
    }

    // Affiche le formulaire d'inscription
    public function registerForm()
    {
        $this->view('user/register');
    }

    // Gère la connexion de l'utilisateur
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        require_once __DIR__ . '/../views/user/login.php';
        $this->view('user/login');
    }

    // Gère l'inscription de l'utilisateur
    public function register()
    {
        var_dump('test');
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $pseudo = htmlspecialchars(trim($_POST['pseudo'] ?? ''));
                $email = htmlspecialchars(trim($_POST['email'] ?? ''));
                $password = htmlspecialchars(trim($_POST['password'] ?? ''));

                // Log des données pour débogage
                error_log("Données soumises : " . json_encode([
                    'pseudo' => $pseudo,
                    'email' => $email,
                    'password' => $password,
                ]));

                if (empty($pseudo) || empty($email) || empty($password)) {
                    throw new Exception("Tous les champs sont obligatoires.");
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception("Email invalide.");
                }

                $userModel = new User();
                $result = $userModel->register($pseudo, $email, $password);

                if ($result === true) {
                    $_SESSION['success_message'] = "Enregistrement réussi !";
                    header("Location: /login");
                    exit;
                } else {
                    throw new Exception($result);
                }
            } else {
                require_once __DIR__ . '/../views/user/register.php';
            }
        } catch (Exception $e) {
            $_SESSION['register_error'] = $e->getMessage();
            error_log("Erreur d'enregistrement : " . $e->getMessage()); // Log de l'erreur pour débogage
            header("Location: /register");
            echo ($e->getMessage());
            exit;
        }
    }
}
