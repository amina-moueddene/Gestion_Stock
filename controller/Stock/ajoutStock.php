<?php
include '../../model/connexion.php';
include '../../model/StockModel.php';

session_start();

if (!empty($_POST['id_article']) && !empty($_POST['quantite']) && !empty($_POST['prix'])) {
    $stockModel = new StockModel($connexion);
    
    if ($stockModel->ajouterStock($_POST['id_article'], $_POST['quantite'], $_POST['prix'])) {
        $stockModel->ajusterQuantiteProduit($_POST['id_article'], $_POST['quantite']);
        $_SESSION['message']['text'] = "Stock ajouté avec succès.";
        $_SESSION['message']['type'] = "success";
    } else {
        $_SESSION['message']['text'] = "Erreur lors de l'ajout du stock.";
        $_SESSION['message']['type'] = "danger";
    }
} else {
    $_SESSION['message']['text'] = "Informations obligatoires manquantes.";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../../vue/stock.php');
exit();
?>
