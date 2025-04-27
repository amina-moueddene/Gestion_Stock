<?php
include '../../model/connexion.php';
include '../../model/ProduitModel.php';

session_start();

if (
    !empty($_POST['nom_produit']) &&
    !empty($_POST['id_categorie']) &&
    !empty($_POST['quantite']) &&
    !empty($_POST['prix_unitaire'])
) {
    $produitModel = new ProduitModel($connexion);
    if ($produitModel->ajouterProduit($_POST['nom_produit'], $_POST['id_categorie'], $_POST['quantite'], $_POST['prix_unitaire'])) {
        $_SESSION['message']['text'] = "Produit ajouté avec succès.";
        $_SESSION['message']['type'] = "success";
    } else {
        $_SESSION['message']['text'] = "Erreur lors de l'ajout du produit.";
        $_SESSION['message']['type'] = "danger";
    }
} else {
    $_SESSION['message']['text'] = "Informations obligatoires manquantes.";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../../vue/produit.php');
exit();
