<?php
include '../../model/connexion.php';
include '../../model/CommandeModel.php';
include '../../model/function.php';

session_start();

if (
    !empty($_POST['id_article']) &&
    !empty($_POST['id_client']) &&
    !empty($_POST['quantite']) &&
    !empty($_POST['prix'])
) {
    $commandeModel = new CommandeModel($connexion);
    $article = getProduit($_POST['id_article']);

    if ($article && $_POST['quantite'] <= $article['quantite']) {
        if ($commandeModel->ajouterCommande($_POST['id_article'], $_POST['id_client'], $_POST['quantite'], $_POST['prix'])) {
            if ($commandeModel->decrementerStock($_POST['id_article'], $_POST['quantite'])) {
                $_SESSION['message']['text'] = "Commande effectuée avec succès";
                $_SESSION['message']['type'] = "success";
            } else {
                $_SESSION['message']['text'] = "Erreur lors de la mise à jour du stock";
                $_SESSION['message']['type'] = "danger";
            }
        } else {
            $_SESSION['message']['text'] = "Erreur lors de la commande";
            $_SESSION['message']['type'] = "danger";
        }
    } else {
        $_SESSION['message']['text'] = "La quantité à vendre n'est pas disponible";
        $_SESSION['message']['type'] = "danger";
    }
} else {
    $_SESSION['message']['text'] = "Informations obligatoires manquantes";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../../vue/stock.php');
exit();
