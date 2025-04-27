<?php
include '../../model/connexion.php';
include '../../model/ClientModel.php';

session_start();

if (
    !empty($_POST['nom']) &&
    !empty($_POST['prenom']) &&
    !empty($_POST['telephone']) &&
    !empty($_POST['adresse']) &&
    !empty($_POST['ville'])
) {
    $clientModel = new ClientModel($connexion);

    $resultat = $clientModel->ajouterClient(
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['telephone'],
        $_POST['adresse'],
        $_POST['ville']
    );

    if ($resultat) {
        $_SESSION['message']['text'] = "Client ajouté avec succès";
        $_SESSION['message']['type'] = "success";
    } else {
        $_SESSION['message']['text'] = "Une erreur s'est produite lors de l'ajout du client";
        $_SESSION['message']['type'] = "danger";
    }
} else {
    $_SESSION['message']['text'] = "Une information obligatoire non renseignée";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../../vue/client.php');
exit;
