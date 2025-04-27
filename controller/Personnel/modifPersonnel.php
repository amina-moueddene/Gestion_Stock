<?php
include '../../model/connexion.php';
include '../../model/PersonnelModel.php';

session_start();

if (
    !empty($_POST['nom']) &&
    !empty($_POST['prenom']) &&
    !empty($_POST['telephone']) &&
    !empty($_POST['adresse']) &&
    !empty($_POST['email']) &&
    !empty($_POST['role']) &&
    !empty($_POST['id'])
) {
    $personnelModel = new PersonnelModel($connexion);
    if ($personnelModel->modifierPersonnel($_POST['id'], $_POST['nom'], $_POST['prenom'], $_POST['telephone'], $_POST['adresse'], $_POST['email'], $_POST['role'])) {
        $_SESSION['message']['text'] = "Personnel modifié avec succès.";
        $_SESSION['message']['type'] = "success";
    } else {
        $_SESSION['message']['text'] = "Aucune modification effectuée.";
        $_SESSION['message']['type'] = "warning";
    }
} else {
    $_SESSION['message']['text'] = "Informations obligatoires manquantes.";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../../vue/personnel.php');
exit();
