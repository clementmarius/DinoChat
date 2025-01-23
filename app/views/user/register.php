<?php
require_once __DIR__ . '/../../controllers/UserController.php';


use App\Controllers\UserController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new UserController();
    $controller->register();
    // var_dump($controller);
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    error_log("Session démarrée.");
}

$error = $_SESSION['register_error'] ?? '';
$success = $_SESSION['success_message'] ?? '';
unset($_SESSION['register_error'], $_SESSION['success_message']);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - DinoChat</title>
    <!-- bootstrap Autorisée possibilité de le personnalisée -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public/css/style.css" rel="stylesheet">

</head>

<body>

    <?php if ($error) : ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($success) : ?>
        <div class="error"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <!-- Carte d'inscription -->
                <h3 class="text-center">Inscription</h3>
                <form method="POST" action="/Dino/DinoChat/app/views/user/register">
                    <!-- Champ pour l'adresse e-mail -->
                    <input type="email" class="form-control" placeholder="Entrez votre e-mail" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    <!-- Champ pour le nom d'utilisateur -->
                    <input type="text" class="form-control" placeholder="Entrez votre pseudo" required value="<?php echo htmlspecialchars($_POST['pseudo'] ?? ''); ?>">
                    <!-- Champ pour le mot de passe -->
                    <input type="password" class="form-control" placeholder="Entrez votre mot de passe" required>
                    <!-- Bouton pour soumettre les informations d'inscription -->
                    <!--                 <button class="btn btn-success w-100">Créer un compte</button>
 --> <!-- Lien pour se connecter -->

                    <input type="submit" value="Register">
                </form>

                <a href="/login" class="text-decoration-none">Déjà inscrit ? Connectez-vous</a>

            </div>
        </div>
    </div>
</body>

</html>