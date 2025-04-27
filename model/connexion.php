<?php

// Vérifier si une session est déjà active
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Démarrer la session si elle n'est pas encore active
}

$nom_serveur = "localhost";
$nom_base_de_donne = "G-stock";
$utilisateur = "root";
$motpass = "";

try {
    $connexion = new PDO("mysql:host=$nom_serveur;dbname=$nom_base_de_donne", $utilisateur, $motpass);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $connexion;
} catch (Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
