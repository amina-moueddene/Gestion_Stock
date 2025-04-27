<?php
include '../../model/connexion.php';
include '../../model/CategorieModel.php';

session_start();

if (!empty($_POST['libelle_categorie']) && !empty($_POST['id'])) {
    $categorieModel = new CategorieModel($connexion);
    $resultat = $categorieModel->modifierCategorie($_POST['id'], $_POST['libelle_categorie']);

    if ($resultat) {
        $_SESSION['message']['text'] = "Catégorie modifiée avec succès";
        $_SESSION['message']['type'] = "success";
    } else {
        $_SESSION['message']['text'] = "Rien n'a été modifié";
        $_SESSION['message']['type'] = "warning";
    }
} else {
    $_SESSION['message']['text'] = "Une information obligatoire non renseignée";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../../vue/categorie.php');
exit;
