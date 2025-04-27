<?php
class ProduitModel {
    private $connexion;

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function ajouterProduit($nomProduit, $idCategorie, $quantite, $prixUnitaire) {
        $sql = "INSERT INTO produit (nom_produit, id_categorie, quantite, prix_unitaire) VALUES (?, ?, ?, ?)";
        $req = $this->connexion->prepare($sql);
        return $req->execute([$nomProduit, $idCategorie, $quantite, $prixUnitaire]);
    }

    public function modifierProduit($id, $nomProduit, $idCategorie, $quantite, $prixUnitaire) {
        $sql = "UPDATE produit SET nom_produit = ?, id_categorie = ?, quantite = ?, prix_unitaire = ? WHERE id = ?";
        $req = $this->connexion->prepare($sql);
        return $req->execute([$nomProduit, $idCategorie, $quantite, $prixUnitaire, $id]);
    }

    public function supprimerProduit($id) {
        $sql = "DELETE FROM produit WHERE id = ?";
        $req = $this->connexion->prepare($sql);
        return $req->execute([$id]);
    }
}
