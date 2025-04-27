<?php
include '../../model/connexion.php';
include '../../model/ClientModel.php';

session_start();

if (!empty($_GET['id'])) {
    $clientModel = new ClientModel($connexion);

    $resultat = $clientModel->supprimerClient($_GET['id']);

    if ($resultat) {
        $_SESSION['message']['text'] = "Client supprimé avec succès";
        $_SESSION['message']['type'] = "success";
    } else {
        $_SESSION['message']['text'] = "Erreur lors de la suppression du client";
        $_SESSION['message']['type'] = "danger";
    }
} else {
    $_SESSION['message']['text'] = "Aucun client sélectionné pour la suppression";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../../vue/client.php');
exit;
