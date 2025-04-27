
<?php
class CategorieModel {
    private $connexion;

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function ajouterCategorie($libelleCategorie) {
        $sql = "INSERT INTO categorie (libelle_categorie) VALUES (?)";
        $req = $this->connexion->prepare($sql);
        return $req->execute([$libelleCategorie]);
    }

    public function modifierCategorie($id, $libelleCategorie) {
        $sql = "UPDATE categorie SET libelle_categorie = ? WHERE id = ?";
        $req = $this->connexion->prepare($sql);
        return $req->execute([$libelleCategorie, $id]);
    }

    public function supprimerCategorie($id) {
        $sql = "DELETE FROM categorie WHERE id = ?";
        $req = $this->connexion->prepare($sql);
        return $req->execute([$id]);
    }
}
