<?php
include 'entete.php'; 

$ventes = getCommande(); // Récupère toutes les ventes

// Si un ID de vente est passé dans l'URL, on récupère les informations de cette vente
$article = null; // Initialisation de la variable $article
if (!empty($_GET['id'])) {
    $article = getCommande($_GET['id']); // Récupère les détails de la vente à modifier
}
?>
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <!-- Formulaire de modification ou d'ajout -->
            <form action=" <?= !empty($_GET['id']) ?  "../controller/Commande/modifCom.php" : "../controller/Commande/AjoutCom.php" ?>" method="post">
            <!-- Champ caché pour l'ID de la vente -->
    <input value="<?= !empty($_GET['id']) ?  $_GET['id'] : "" ?>" type="hidden" name="id" id="id">

    <!-- Champ caché pour l'ID de l'article (si en mode modification) -->
    <input value="<?= !empty($article) ? $article['id_article'] : "" ?>" type="hidden" name="id_article" id="id_article">

    <!-- Champ caché pour l'ID du client (si en mode modification) -->
    <input value="<?= !empty($article) ? $article['id_client'] : "" ?>" type="hidden" name="id_client" id="id_client">

    <!-- Formulaire pour sélectionner un article -->
    <label for="id_article">Article</label>
    <select onchange="setPrix()" name="id_article" id="id_article">
        <?php
        $articles = getProduit();
        if (!empty($articles) && is_array($articles)) {
            foreach ($articles as $key => $value) {
        ?>
                <option data-prix="<?= $value['prix_unitaire'] ?>" value="<?= $value['id'] ?>" <?= !empty($article) && $article['id_article'] == $value['id'] ? 'selected' : '' ?>>
                    <?= $value['nom_produit'] . " - " . $value['quantite'] . " disponible" ?>
                </option>
        <?php
            }
        }
        ?>
    </select>

    <!-- Formulaire pour sélectionner un client -->
    <label for="id_client">Client</label>
    <select name="id_client" id="id_client">
        <?php
        $clients = getClient();
        if (!empty($clients) && is_array($clients)) {
            foreach ($clients as $key => $value) {
        ?>
                <option value="<?= $value['id'] ?>" <?= !empty($article) && $article['id_client'] == $value['id'] ? 'selected' : '' ?>>
                    <?= $value['nom'] . " " . $value['prenom'] ?>
                </option>
        <?php
            }
        }
        ?>
    </select>

    <!-- Quantité et prix -->
    <label for="quantite">Quantité</label>
    <input onkeyup="setPrix()" value="<?= !empty($article) ?  $article['quantite'] : "" ?>" type="number" name="quantite" id="quantite" placeholder="Veuillez saisir la quantité">

    <label for="prix">Prix</label>
    <input value="<?= !empty($article) ?  $article['prix'] : "" ?>" type="number" name="prix" id="prix" placeholder="Veuillez saisir le prix">

    <button type="submit">Valider</button>
</form>


        </div>
        <!-- Tableau des ventes -->
        <div class="box">
            <table class="mtable">
                <tr>
                    <th>Article</th>
                    <th>Client</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                <?php
                if (!empty($ventes) && is_array($ventes)) {
                    foreach ($ventes as $key => $value) {
                ?>
                        <tr>
                            <td><?= $value['nom_produit'] ?></td>
                            <td><?= $value['nom'] . " " . $value['prenom'] ?></td>
                            <td><?= $value['quantite'] ?></td>
                            <td><?= $value['prix'] ?></td>
                            <td><?= date('d/m/Y H:i:s', strtotime($value['date_vente'])) ?></td>
                            <td>
                                <a href="?id=<?= $value['id'] ?>"><i class='bx bx-edit-alt'></i></a> <!-- Lien pour modifier -->
                                <a onclick="annuleCom(<?= isset($value['id']) ? $value['id'] : '' ?>, <?= isset($value['idArticle']) ? $value['idArticle'] : '' ?>, <?= isset($value['quantite']) ? $value['quantite'] : '' ?>)" style="color: red;">
                                    <i class='bx bx-stop-circle'></i>
                                </a>
                                <a href="recuVente.php?id=<?= $value['id'] ?>"><i class='bx bx-receipt'></i></a>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>
</div>

<?php
include 'pied.php'; // Pied de page
?>

<script>
    function annuleCom(idVente, idArticle, quantite) {
        if (confirm("Voulez-vous vraiment annuler cette vente ?")) {
            window.location.href = "../controller/Commande/annuleCom.php?idVente=" + idVente + "&idArticle=" + idArticle + "&quantite=" + quantite;
        }
    }

    function setPrix() {
        var article = document.querySelector('#id_article');
        var quantite = document.querySelector('#quantite');
        var prix = document.querySelector('#prix');

        var prixUnitaire = article.options[article.selectedIndex].getAttribute('data-prix');
        prix.value = Number(quantite.value) * Number(prixUnitaire);
    }
</script>
