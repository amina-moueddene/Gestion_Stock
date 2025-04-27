<?php
include 'entete.php';

?>

<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <div class="right-side">
                <div class="box-topic">Commande</div>
                <div class="number"><?php echo getAllCommande()['nbre'] ?></div>
                <div class="indicator">
                </div>
            </div>
            <i class="bx bx-cart-alt cart"></i>
        </div>
        <div class="box">
            <div class="right-side">
                <div class="box-topic">Client</div>
                <div class="number"><?php echo getAllClient()['nbre'] ?></div>
                <div class="indicator">
                </div>
            </div>
            <i class="bx bxs-cart-add cart two"></i>
        </div>
        <div class="box">
            <div class="right-side">
                <div class="box-topic">Produit</div>
                <div class="number"><?php echo getAllProduit()['nbre'] ?></div>
                <div class="indicator">
                </div>
            </div>
            <i class="bx bx-cart cart three"></i>
        </div>
        <div class="box">
            <div class="right-side">
                <div class="box-topic">CA</div>
                <div class="number"><?php echo number_format(getCA()['prix'], 0, ',', ' ') ?></div>
            </div>
            <i class="bx bxs-cart-download cart four"></i>
        </div>
    </div>

    <div class="sales-boxes">
        <div class="recent-sales box">
            <div class="title">Commandes recentes</div>
            <?php
            $ventes = getLastVente();
            ?>
            <div class="sales-details">
                <ul class="details">
                    <li class="topic">Date</li>
                    <?php
                    foreach ($ventes as $key => $value) {
                    ?>
                        <li><?php echo date('d M Y', strtotime($value['date_vente'])) ?></li>
                    <?php
                    }
                    ?>
                </ul>
                <ul class="details">
                    <li class="topic">Client</li>
                    <?php
                    foreach ($ventes as $key => $value) {
                    ?>
                        <li><?php echo $value['nom'] . " " . $value['prenom'] ?></li>
                    <?php
                    }
                    ?>
                </ul>
                <ul class="details">
                    <li class="topic">Produit</li>
                    <?php
                    foreach ($ventes as $key => $value) {
                    ?>
                        <li><?php echo $value['nom_produit'] ?></li>
                    <?php
                    }
                    ?>
                </ul>
                <ul class="details">
                    <li class="topic">Prix</li>
                    <?php
                    foreach ($ventes as $key => $value) {
                    ?>
                        <li><?php echo number_format($value['prix'], 0, ",", " ") . " MAD" ?></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            
        </div>
        <div class="top-sales box">
            <div class="title">Produit le plus vendu</div>
            <ul class="top-sales-details">
                <?php
                $article = getMostVente();
                foreach ($article as $key => $value) {
                ?>
                    <li>   
                        <span class="product"><?php echo $value['nom_produit'] ?></span>
                    
                        <span class="price"><?php echo number_format($value['prix'], 0, ",", " ") . " MAD" ?></span>
                    </li>
                <?php
                }
                ?>
                
            </ul>
        </div>
    </div>
</div>
</section>

<?php
include 'pied.php';
?>