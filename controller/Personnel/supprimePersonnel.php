<?php
include '../../model/connexion.php';
include '../../model/PersonnelModel.php';

session_start();

if (!empty($_GET['id'])) {
    $personnelModel = new PersonnelModel($connexion);
    if ($personnelModel->supprimerPersonnel($_GET['id'])) {
        $_SESSION['message']['text'] = "Personnel supprimé avec succès.";
        $_SESSION['message']['type'] = "success";
    } else {
        $_SESSION['message']['text'] = "Erreur lors de la suppression du personnel.";
        $_SESSION['message']['type'] = "danger";
    }
} else {
    $_SESSION['message']['text'] = "ID du personnel manquant.";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../../vue/personnel.php');
exit();
