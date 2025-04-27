<?php
include '../../model/connexion.php';
include '../../model/CategorieModel.php';
session_start();

if (!empty($_POST['libelle_categorie'])) {
    $categorieModel = new CategorieModel($connexion);
    $resultat = $categorieModel->ajouterCategorie($_POST['libelle_categorie']);

    if ($resultat) {
        $_SESSION['message']['text'] = "Catégorie ajoutée avec succès";
        $_SESSION['message']['type'] = "success";
    } else {
        $_SESSION['message']['text'] = "Une erreur s'est produite lors de l'ajout de la catégorie";
        $_SESSION['message']['type'] = "danger";
    }
} else {
    $_SESSION['message']['text'] = "Une information obligatoire non renseignée";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../../vue/categorie.php');
exit;
