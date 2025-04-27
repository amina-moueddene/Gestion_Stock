<?php
include '../../model/connexion.php';
include '../../model/CommandeModel.php';

session_start();

if (!empty($_GET['id'])) {
    $commandeModel = new CommandeModel($connexion);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $resultat = $commandeModel->modifierCommande(
            $_GET['id'],
            $_POST['id_article'],
            $_POST['id_client'],
            $_POST['quantite'],
            $_POST['prix']
        );

        if ($resultat) {
            $_SESSION['message']['text'] = "Commande modifiée avec succès.";
            $_SESSION['message']['type'] = "success";
        } else {
            $_SESSION['message']['text'] = "Erreur lors de la modification de la commande.";
            $_SESSION['message']['type'] = "danger";
        }
        header('Location: ../vue/stock.php');
        exit();
    }
} else {
    $_SESSION['message']['text'] = "Erreur : ID de la commande manquant.";
    $_SESSION['message']['type'] = "danger";

    header('Location: ../../vue/stock.php');

    exit();
}
