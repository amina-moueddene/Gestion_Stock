<?php
include 'entete.php';

if (!empty($_GET['id'])) {
    $fournisseur = getPersonnel($_GET['id']);
}

?>
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action=" <?= !empty($_GET['id']) ?  "../controller/Personnel/modifPersonnel.php" : "../controller/Personnel/ajoutPersonnel.php" ?>" method="post">
                <label for="nom">Nom</label>
                <input value="<?= !empty($_GET['id']) ?  $fournisseur['nom'] : "" ?>" type="text" name="nom" id="nom" placeholder="Veuillez saisir le nom">
                <input value="<?= !empty($_GET['id']) ?  $fournisseur['id'] : "" ?>" type="hidden" name="id" id="id" >
                
                <label for="prenom">Prénom</label>
                <input value="<?= !empty($_GET['id']) ?  $fournisseur['prenom'] : "" ?>" type="text" name="prenom" id="prenom" placeholder="Veuillez saisir le prénom">

                <label for="telephone">N° de téléphone</label>
                <input value="<?= !empty($_GET['id']) ?  $fournisseur['telephone'] : "" ?>" type="text" name="telephone" id="telephone" placeholder="Veuillez saisir le N° de téléphone">
                
                <label for="adresse">Adresse</label>
                <input value="<?= !empty($_GET['id']) ?  $fournisseur['adresse'] : "" ?>" type="text" name="adresse" id="adresse" placeholder="Veuillez saisir l'adresse">

                <label for="email">Email</label>
                <input value="<?= !empty($_GET['id']) ?  $fournisseur['email'] : "" ?>" type="text" name="email" id="email" placeholder="Veuillez saisir l'email">

                <label for="role">Role</label>
                <input value="<?= !empty($_GET['id']) ?  $fournisseur['role'] : "" ?>" type="text" name="role" id="role" placeholder="Veuillez saisir le role">

                
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
        <div class="box">
            <table class="mtable">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Téléphone</th>
                    <th>Adresse</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                <?php
                $fournisseurs = getPersonnel();

                if (!empty($fournisseurs) && is_array($fournisseurs)) {
                    foreach ($fournisseurs as $key => $value) {
                ?>
                        <tr>
                            <td><?= $value['nom'] ?></td>
                            <td><?= $value['prenom'] ?></td>
                            <td><?= $value['telephone'] ?></td>
                            <td><?= $value['adresse'] ?></td>
                            <td><?= $value['email'] ?></td>
                            <td><?= $value['role'] ?></td>
                            <td>
                                <a href="?id=<?= $value['id'] ?>"><i class='bx bx-edit-alt'></i></a> <!-- Lien pour modifier -->
                                <a onclick="return confirm('Voulez-vous vraiment supprimer ce personnel ?')" href="../controller/Personnel/supprimePersonnel.php?id=<?= $value['id'] ?>" style="color: red;">
                                    <i class='bx bx-trash'></i>
                                </a> <!-- Lien pour supprimer -->
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
</section>

<?php
include 'pied.php';
?>