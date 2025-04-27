<?php
include '../../model/connexion.php';
include '../../model/ProduitModel.php';

session_start();

if (!empty($_GET['id'])) {
    $produitModel = new ProduitModel($connexion);
    if ($produitModel->supprimerProduit($_GET['id'])) {
        $_SESSION['message']['text'] = "Produit supprimé avec succès.";
        $_SESSION['message']['type'] = "success";
    } else {
        $_SESSION['message']['text'] = "Erreur lors de la suppression du produit.";
        $_SESSION['message']['type'] = "danger";
    }
} else {
    $_SESSION['message']['text'] = "ID de produit manquant.";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../../vue/produit.php');
exit();
