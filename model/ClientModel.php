<?php
class ClientModel {
    private $connexion;

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function ajouterClient($nom, $prenom, $telephone, $adresse, $ville) {
        $sql = "INSERT INTO client (nom, prenom, telephone, adresse, ville) VALUES (?, ?, ?, ?, ?)";
        $req = $this->connexion->prepare($sql);
        return $req->execute([$nom, $prenom, $telephone, $adresse, $ville]);
    }

    public function modifierClient($id, $nom, $prenom, $telephone, $adresse) {
        $sql = "UPDATE client SET nom = ?, prenom = ?, telephone = ?, adresse = ? WHERE id = ?";
        $req = $this->connexion->prepare($sql);
        return $req->execute([$nom, $prenom, $telephone, $adresse, $id]);
    }

    public function supprimerClient($id) {
        $sql = "DELETE FROM client WHERE id = ?";
        $req = $this->connexion->prepare($sql);
        return $req->execute([$id]);
    }
}
