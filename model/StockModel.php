<?php
class StockModel {
    private $connexion;

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    // Ajouter du stock
    public function ajouterStock($idArticle, $quantite, $prix) {
        $sql = "INSERT INTO stock (id_article, quantite, prix) VALUES (?, ?, ?)";
        $req = $this->connexion->prepare($sql);
        return $req->execute([$idArticle, $quantite, $prix]);
    }

    // Modifier un stock
    public function modifierStock($id, $idArticle, $quantite, $prix) {
        $sql = "UPDATE stock SET id_article = ?, quantite = ?, prix = ? WHERE id = ?";
        $req = $this->connexion->prepare($sql);
        return $req->execute([$idArticle, $quantite, $prix, $id]);
    }

    // Supprimer un stock
    public function supprimerStock($id) {
        $sql = "DELETE FROM stock WHERE id = ?";
        $req = $this->connexion->prepare($sql);
        return $req->execute([$id]);
    }

    // Mettre à jour la quantité d'un produit
    public function ajusterQuantiteProduit($idArticle, $quantiteAjout) {
        $sql = "UPDATE produit SET quantite = quantite + ? WHERE id = ?";
        $req = $this->connexion->prepare($sql);
        $req->execute([$quantiteAjout, $idArticle]);
    }

    // Récupérer un stock par ID
    public function recupererStockParId($id) {
        $sql = "SELECT * FROM stock WHERE id = ?";
        $req = $this->connexion->prepare($sql);
        $req->execute([$id]);
        return $req->fetch();
    }
}
?>
