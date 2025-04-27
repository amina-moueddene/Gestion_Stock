<?php
class CommandeModel {
    private $connexion;

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function ajouterCommande($idArticle, $idClient, $quantite, $prix) {
        $sql = "INSERT INTO commande (id_article, id_client, quantite, prix) VALUES (?, ?, ?, ?)";
        $req = $this->connexion->prepare($sql);
        return $req->execute([$idArticle, $idClient, $quantite, $prix]);
    }

    public function decrementerStock($idArticle, $quantite) {
        $sql = "UPDATE produit SET quantite = quantite - ? WHERE id = ?";
        $req = $this->connexion->prepare($sql);
        return $req->execute([$quantite, $idArticle]);
    }

    public function modifierCommande($id, $idArticle, $idClient, $quantite, $prix) {
        $sql = "UPDATE commande SET id_article = ?, id_client = ?, quantite = ?, prix = ?, date_commande = NOW() WHERE id = ?";
        $req = $this->connexion->prepare($sql);
        return $req->execute([$idArticle, $idClient, $quantite, $prix, $id]);
    }

    public function annulerCommande($idCommande, $idArticle, $quantite) {
        try {
            $this->connexion->beginTransaction();

            // Réinjecter la quantité annulée dans le stock
            $sqlUpdateArticle = "UPDATE produit SET quantite = quantite + ? WHERE id = ?";
            $reqUpdateArticle = $this->connexion->prepare($sqlUpdateArticle);
            $reqUpdateArticle->execute([$quantite, $idArticle]);

            // Marquer la commande comme annulée
            $sqlAnnulerCommande = "UPDATE commande SET etat = 0 WHERE id = ?";
            $reqAnnulerCommande = $this->connexion->prepare($sqlAnnulerCommande);
            $reqAnnulerCommande->execute([$idCommande]);

            $this->connexion->commit();
            return true;
        } catch (Exception $e) {
            $this->connexion->rollBack();
            return false;
        }
    }
}
