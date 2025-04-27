<?php
include '../../model/connexion.php';
include '../../model/ClientModel.php';

session_start();

if (
    !empty($_POST['nom']) &&
    !empty($_POST['prenom']) &&
    !empty($_POST['telephone']) &&
    !empty($_POST['adresse']) &&
    !empty($_POST['id'])
) {
    $clientModel = new ClientModel($connexion);

    $resultat = $clientModel->modifierClient(
        $_POST['id'],
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['telephone'],
        $_POST['adresse']
    );

    if ($resultat) {
        $_SESSION['message']['text'] = "Client modifié avec succès";
        $_SESSION['message']['type'] = "success";
    } else {
        $_SESSION['message']['text'] = "Rien n'a été modifié";
        $_SESSION['message']['type'] = "warning";
    }
} else {
    $_SESSION['message']['text'] = "Une information obligatoire non renseignée";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../../vue/client.php');
exit;
