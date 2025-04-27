<?php
include 'entete.php';

if (!empty($_GET['id'])) {
    $article = getProduit($_GET['id']);
}

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 7; // Nombre d'articles par page
$offset = ($page - 1) * $limit;

?>
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action=" <?= !empty($_GET['id']) ?  "../controller/Produit/modifProduit.php" : "../controller/Produit/ajoutProduit.php" ?>" method="post" enctype="multipart/form-data">
                <label for="nom_produit">Nom de l'article</label>
                <input value="<?= !empty($_GET['id']) ?  $article['nom_produit'] : "" ?>" type="text" name="nom_produit" id="nom_produit" placeholder="Veuillez saisir le nom">
                <input value="<?= !empty($_GET['id']) ?  $article['id'] : "" ?>" type="hidden" name="id" id="id">

                <label for="id_categorie">Catégorie</label>
                <select name="id_categorie" id="id_categorie">
                    <option value="">--Choisir une catégorie--</option>
                    <?php

                    $categories = getCategorie();
                    if (is_array($categories) && !empty($categories)) {
                        foreach ($categories as $key => $value) {
                    ?>
                            <option <?= !empty($_GET['id']) && $article['id_categorie'] == $value['id'] ?  "selected" : "" ?> value="<?= $value['id'] ?>"><?= $value['libelle_categorie'] ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>

                <label for="quantite">Quantité</label>
                <input value="<?= !empty($_GET['id']) ?  $article['quantite'] : "" ?>" type="number" name="quantite" id="quantite" placeholder="Veuillez saisir la quantité">

                <label for="prix_unitaire">Prix unitaire</label>
                <input value="<?= !empty($_GET['id']) ?  $article['prix_unitaire'] : "" ?>" type="number" name="prix_unitaire" id="prix_unitaire" placeholder="Veuillez saisir le prix">


                <button type="submit">Valider</button>

                <?php
                if (!empty($_SESSION['message']['text'])) {
                ?>
                    <div class="alert <?= $_SESSION['message']['type'] ?>">
                        <?= $_SESSION['message']['text'] ?>
                    </div>
                <?php
                }
                ?>
            </form>

        </div>
        <div style="display: block;" class="box">

            <br>
            <table class="mtable">
                <tr>
                    <th>Nom </th>
                    <th>Catégorie</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Action</th>
                </tr>
                <?php
                $total_articles = 0;
                $total_pages = 0;
                if (!empty($_GET['s'])) {
                    $articles = getProduit(null, $_GET, $limit, $offset);

                    $count = countArticle($_GET);
                    $total_articles = $count['total'];
                    $total_pages = ceil($total_articles / $limit);
                } else {
                    $articles = getProduit(null, null, $limit, $offset);

                    $count = countArticle(null);
                    $total_articles = $count['total'];
                    $total_pages = ceil($total_articles / $limit);
                }



                if (!empty($articles) && is_array($articles)) {
                    foreach ($articles as $key => $value) {
                ?>
                        <tr>
                            <td><?= $value['nom_produit'] ?></td>
                            <td><?= $value['libelle_categorie'] ?></td>
                            <td><?= $value['quantite'] ?></td>
                            <td><?= $value['prix_unitaire'] ?></td>
                            <td>
                                <a href="?id=<?= $value['id'] ?>"><i class='bx bx-edit-alt'></i></a> <!-- Lien pour modifier -->
                                <a onclick="return confirm('Voulez-vous vraiment supprimer cet article ?')" href="../controller/Produit/supprimeProduit.php?id=<?= $value['id'] ?>" style="color: red;">
                                    <i class='bx bx-trash'></i>
                                </a> <!-- Lien pour supprimer -->
                            </td>
                        </tr>
                <?php

                    }
                }
                ?>
            </table>
            <?php

            echo "<div class='pagination'>";
             
            if ($page > 1) {
                $prev_page = $page - 1;
                echo "<a href='?page=$prev_page'>&laquo; Précédent</a> ";
            }
            
            for ($i = 1; $i <= $total_pages; $i++) {
                
                if($i==$page) $active = "active"; else $active = "";
                echo "<a class='$active' href='?page=$i'>$i</a> ";
            }

            

            // Lien vers la page suivante
            if ($page < $total_pages) {
                $next_page = $page + 1;
                echo "<a href='?page=$next_page'>Suivant &raquo;</a> ";
            }
            echo "</div>";

            ?>
        </div>
    </div>

</div>
</section>

<?php
include 'pied.php';
?>