<?php
include '../model/connexion.php'; // Connexion à la base
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Récupérer l'utilisateur via son email
    $stmt = $connexion->prepare("SELECT * FROM personnel WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Vérifier le mot de passe en utilisant MD5
    if ($user && md5($password) === $user['password']) {
        // Enregistrer les infos dans la session
        $_SESSION['id'] = $user['id'];
        $_SESSION['role'] = $user['role']; // Rôle utilisateur
        $_SESSION['nom'] = $user['nom'];  // Nom utilisateur
        $_SESSION['prenom'] = $user['prenom']; // Prénom utilisateur

        // Rediriger après connexion
        header("Location: ../vue/dashboard.php");
    } else {
        echo "Email ou mot de passe incorrect.";
    }
}
?>
