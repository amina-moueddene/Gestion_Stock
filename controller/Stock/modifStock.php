<?php
include '../../model/connexion.php';
include '../../model/StockModel.php';

session_start();

if (
    !empty($_POST['id']) &&
    !empty($_POST['id_article']) &&
    !empty($_POST['quantite']) &&
    !empty($_POST['prix'])
) {
    $stockModel = new StockModel($connexion);
    $ancienStock = $stockModel->recupererStockParId($_POST['id']);
    
    if ($ancienStock) {
        if ($stockModel->modifierStock($_POST['id'], $_POST['id_article'], $_POST['quantite'], $_POST['prix'])) {
            $quantiteDifference = $_POST['quantite'] - $ancienStock['quantite'];
            $stockModel->ajusterQuantiteProduit($_POST['id_article'], $quantiteDifference);

            $_SESSION['message']['text'] = "Stock modifié avec succès.";
            $_SESSION['message']['type'] = "success";
        } else {
            $_SESSION['message']['text'] = "Aucune modification apportée.";
            $_SESSION['message']['type'] = "warning";
        }
    } else {
        $_SESSION['message']['text'] = "Stock introuvable.";
        $_SESSION['message']['type'] = "danger";
    }
} else {
    $_SESSION['message']['text'] = "Informations obligatoires manquantes.";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../../vue/stock.php');
exit();
?>
