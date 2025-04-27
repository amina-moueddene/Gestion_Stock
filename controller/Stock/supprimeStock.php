<?php
include '../../model/connexion.php';
include '../../model/StockModel.php';

session_start();

if (!empty($_GET['id'])) {
    $stockModel = new StockModel($connexion);
    $ancienStock = $stockModel->recupererStockParId($_GET['id']);

    if ($ancienStock) {
        if ($stockModel->supprimerStock($_GET['id'])) {
            $stockModel->ajusterQuantiteProduit($ancienStock['id_article'], -$ancienStock['quantite']);
            $_SESSION['message']['text'] = "Stock supprimé avec succès.";
            $_SESSION['message']['type'] = "success";
        } else {
            $_SESSION['message']['text'] = "Erreur lors de la suppression du stock.";
            $_SESSION['message']['type'] = "danger";
        }
    } else {
        $_SESSION['message']['text'] = "Stock introuvable.";
        $_SESSION['message']['type'] = "danger";
    }
} else {
    $_SESSION['message']['text'] = "ID de stock manquant.";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../../vue/stock.php');
exit();
?>
