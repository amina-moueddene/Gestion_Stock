<?php
class PersonnelModel {
    private $connexion;

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function ajouterPersonnel($nom, $prenom, $telephone, $adresse, $email, $role) {
        $sql = "INSERT INTO personnel (nom, prenom, telephone, adresse, email, role) VALUES (?, ?, ?, ?, ?, ?)";
        $req = $this->connexion->prepare($sql);
        return $req->execute([$nom, $prenom, $telephone, $adresse, $email, $role]);
    }

    public function modifierPersonnel($id, $nom, $prenom, $telephone, $adresse, $email, $role) {
        $sql = "UPDATE personnel SET nom = ?, prenom = ?, telephone = ?, adresse = ?, email = ?, role = ? WHERE id = ?";
        $req = $this->connexion->prepare($sql);
        return $req->execute([$nom, $prenom, $telephone, $adresse, $email, $role, $id]);
    }

    public function supprimerPersonnel($id) {
        $sql = "DELETE FROM personnel WHERE id = ?";
        $req = $this->connexion->prepare($sql);
        return $req->execute([$id]);
    }
}
