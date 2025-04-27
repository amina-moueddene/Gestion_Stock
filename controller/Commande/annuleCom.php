<?php
include '../../model/connexion.php';
include '../../model/CommandeModel.php';

session_start();

if (!empty($_GET['idVente']) && !empty($_GET['idArticle']) && !empty($_GET['quantite'])) {
    $commandeModel = new CommandeModel($connexion);

    if ($commandeModel->annulerCommande($_GET['idVente'], $_GET['idArticle'], $_GET['quantite'])) {
        $_SESSION['message']['text'] = "Commande annulée et stock rétabli.";
        $_SESSION['message']['type'] = "success";
    } else {
        $_SESSION['message']['text'] = "Erreur lors de l'annulation de la commande.";
        $_SESSION['message']['type'] = "danger";
    }
} else {
    $_SESSION['message']['text'] = "Erreur : Informations manquantes.";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../../vue/commande.php');
exit();
