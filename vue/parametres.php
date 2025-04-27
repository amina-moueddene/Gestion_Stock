<?php

include 'entete.php';
include_once '../controller/parametres.php'; // Inclure le modèle pour la fonction getUserById



$id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['id']; // Récupérer l'ID de l'utilisateur

// Récupérer l'utilisateur
$user = getUserById($id);
if (!$user) {
    echo "Aucun utilisateur trouvé.";
    exit;
}

// Message de succès ou d'erreur
$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Réinitialiser après l'affichage
}

// Mise à jour des données
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];

    // Mettre à jour les données
    updateUser($id, $nom, $email);

    // Définir un message de succès
    $_SESSION['message'] = 'Vos informations ont été mises à jour avec succès.';

    // Rafraîchir la page après la mise à jour
    header("Location: parametres.php?id=" . $id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Profile Edit</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
<div class="container">
    <div class="main-body">
        <div class="row gutters-sm">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-3" style="padding-top: 50px" >Modifier le profil</h4>

                        <!-- Affichage du message si les données sont modifiées -->
                        <?php if ($message): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="name">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>  
                            <button type="submit" class="btn btn-primary" style="backgeound: rgb(34 139 120) ;">Enregistrer</button>
                            <a href="dashboard.php" class="btn btn-secondary">Annuler</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
