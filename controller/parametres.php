<?php
include_once '../model/connexion.php';

// Fonction pour récupérer un personnel par ID
function getUserById($id) {
    global $connexion;
    $stmt = $connexion->prepare("SELECT * FROM personnel WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);  // Retourne le personnel ou false si non trouvé
}

// Fonction pour mettre à jour les informations de l'personnel
function updateUser($id, $nom, $email) {
    global $connexion;
    $stmt = $connexion->prepare("UPDATE personnel SET nom = :nom, email = :email WHERE id = :id");
    $stmt->execute([
        'nom' => $nom,
        'email' => $email,
        'id' => $id,
    ]);
}
?>
