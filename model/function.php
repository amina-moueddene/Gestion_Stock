<?php
include '../model/connexion.php';

function getProduit($id = null, $searchDATA = array(), $limit = null, $offset = null)
{
    $pagination = "";
    if (!empty($limit) && (!empty($offset) || $offset == 0)) {
        $pagination = " LIMIT $limit OFFSET $offset";
    }
    if (!empty($id)) {
        $sql = "SELECT a.id AS id, id_categorie, nom_produit, libelle_categorie, quantite, prix_unitaire
        FROM Produit AS a, categorie AS c WHERE a.id=? AND c.id=a.id_categorie";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute(array($id));

        return $req->fetch();
    } elseif (!empty($searchDATA)) {
        $search = "";
        extract($searchDATA);
        if (!empty($nom_produit)) $search .= " AND a.nom_produit LIKE '%$nom_produit%' ";
        if (!empty($id_categorie)) $search .= " AND a.id_categorie = $id_categorie ";
        if (!empty($quantite)) $search .= " AND a.quantite = $quantite ";
        if (!empty($prix_unitaire)) $search .= " AND a.prix_unitaire = $prix_unitaire ";

        $sql = "SELECT a.id AS id, id_categorie, nom_produit, libelle_categorie, quantite, prix_unitaire
        FROM produit AS a, categorie AS c WHERE c.id=a.id_categorie $search $pagination";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetchAll();
    } else {
        $sql = "SELECT a.id AS id, id_categorie, nom_produit, libelle_categorie, quantite, prix_unitaire
        FROM produit AS a, categorie AS c WHERE c.id=a.id_categorie $pagination";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute();
        return $req->fetchAll();
    }
}


function countArticle($searchDATA = array())
{

   if (!empty($searchDATA)) {
        $search = "";
        extract($searchDATA);
        if (!empty($nom_produit)) $search .= " AND a.nom_produit LIKE '%$nom_produit%' ";
        if (!empty($id_categorie)) $search .= " AND a.id_categorie = $id_categorie ";
        if (!empty($quantite)) $search .= " AND a.quantite = $quantite ";
        if (!empty($prix_unitaire)) $search .= " AND a.prix_unitaire = $prix_unitaire ";
       
        
        $sql = "SELECT COUNT(*) AS total FROM produit AS a, categorie AS c WHERE c.id=a.id_categorie $search";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetch();
    } else {
        $sql = "SELECT COUNT(*) AS total 
        FROM produit AS a, categorie AS c WHERE c.id=a.id_categorie";
        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute();
        return $req->fetch();
    }
}

function getClient($id = null)
{
    if (!empty($id)) {
        $sql = "SELECT * FROM client WHERE id=?";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute(array($id));

        return $req->fetch();
    } else {
        $sql = "SELECT * FROM client";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetchAll();
    }
}

function getCommande($id = null)
{
    if (!empty($id)) {
        $sql = "SELECT nom_produit, nom, prenom, c.telephone, c.adresse, v.quantite, prix, date_vente, v.id, prix_unitaire, v.id_article, v.id_client
                FROM client AS c, commande AS v, produit AS a
                WHERE v.id_article = a.id AND v.id_client = c.id AND v.id = ? AND etat = ?";

        $req = $GLOBALS['connexion']->prepare($sql);
        $req->execute(array($id, 1));

        return $req->fetch(); // Retourne une seule ligne de résultat
    } else {
        $sql = "SELECT nom_produit, nom, prenom, c.telephone, c.adresse, v.quantite, prix, date_vente, v.id, a.id AS idArticle, v.id_client
                FROM client AS c, commande AS v, produit AS a
                WHERE v.id_article = a.id AND v.id_client = c.id AND etat = ?";

        $req = $GLOBALS['connexion']->prepare($sql);
        $req->execute(array(1));

        return $req->fetchAll(); // Retourne plusieurs lignes
    }
}



function getPersonnel($id = null)
{
    if (!empty($id)) {
        $sql = "SELECT * FROM personnel WHERE id=?";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute(array($id));

        return $req->fetch();
    } else {
        $sql = "SELECT * FROM personnel";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetchAll();
    }
}

function getStock($id = null)
{
    if (!empty($id)) {
        $sql = "SELECT nom_produit, co.quantite, prix, date_commande, co.id, prix_unitaire
                FROM stock AS co
                INNER JOIN produit AS a ON co.id_article = a.id
                WHERE co.id = ?";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute(array($id));

        return $req->fetch();
    } else {
        $sql = "SELECT nom_produit, co.quantite, prix, date_commande, co.id, a.id AS idArticle
                FROM stock AS co
                INNER JOIN produit AS a ON co.id_article = a.id";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetchAll();
    }
}


function getAllStock()
{
    $sql = "SELECT COUNT(*) AS nbre FROM stock";

    $req = $GLOBALS['connexion']->prepare($sql);

    $req->execute();

    return $req->fetch();
}

function getAllcommande()
{
    $sql = "SELECT COUNT(*) AS nbre FROM commande WHERE etat=?";

    $req = $GLOBALS['connexion']->prepare($sql);

    $req->execute(array(1));

    return $req->fetch();
}

function getAllClient()
{
    $sql = "SELECT COUNT(*) AS nbre FROM client";

    $req = $GLOBALS['connexion']->prepare($sql);

    $req->execute(); // Pas besoin de paramètres ici

    return $req->fetch(PDO::FETCH_ASSOC); // Pour garantir un tableau associatif
}


function getAllProduit()
{
    $sql = "SELECT COUNT(*) AS nbre FROM produit";

    $req = $GLOBALS['connexion']->prepare($sql);

    $req->execute();

    return $req->fetch();
}

function getCA()
{
    $sql = "SELECT SUM(prix) AS prix FROM commande WHERE etat IS NOT NULL";

    $req = $GLOBALS['connexion']->prepare($sql);

    $req->execute();

    return $req->fetch();
}

function getLastVente()
{

    $sql = "SELECT nom_produit, nom, prenom, v.quantite, prix, date_vente, v.id, a.id AS idArticle
        FROM client AS c, commande AS v, produit AS a WHERE v.id_article=a.id AND v.id_client=c.id AND etat=? 
        ORDER BY date_vente DESC LIMIT 10";

    $req = $GLOBALS['connexion']->prepare($sql);

    $req->execute(array(1));

    return $req->fetchAll();
}

function getMostVente()
{

    $sql = "SELECT nom_produit, SUM(prix) AS prix
        FROM client AS c, commande AS v, produit AS a WHERE v.id_article=a.id AND v.id_client=c.id AND etat=? 
        GROUP BY a.id
        ORDER BY SUM(prix) DESC LIMIT 10";

    $req = $GLOBALS['connexion']->prepare($sql);

    $req->execute(array(1));

    return $req->fetchAll();
}

function getCategorie($id = null)
{
    if (!empty($id)) {
        $sql = "SELECT * FROM categorie WHERE id=?";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute(array($id));

        return $req->fetch();
    } else {
        $sql = "SELECT * FROM categorie";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetchAll();
    }
}
