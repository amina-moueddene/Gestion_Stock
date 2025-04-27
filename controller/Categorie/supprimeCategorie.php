<?php
include '../../model/connexion.php';
include '../../model/CategorieModel.php';

session_start();

if (!empty($_GET['id'])) {
    $categorieModel = new CategorieModel($connexion);
    $resultat = $categorieModel->supprimerCategorie($_GET['id']);

    if ($resultat) {
        $_SESSION['message']['text'] = "Catégorie supprimée avec succès";
        $_SESSION['message']['type'] = "success";
    } else {
        $_SESSION['message']['text'] = "Erreur lors de la suppression de la catégorie";
        $_SESSION['message']['type'] = "danger";
    }
} else {
    $_SESSION['message']['text'] = "ID de catégorie manquant";
    $_SESSION['message']['type'] = "warning";
}

header('Location: ../../vue/categorie.php');
exit;
