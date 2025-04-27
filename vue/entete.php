<?php
session_start();

// Vérifier si le personnel est connecté
if (!isset($_SESSION['id'])) {
    header("Location: ../vue/login.php");
    exit;
}

// Connexion à la base de données (assurez-vous que la connexion est bien incluse ici)
include_once '../model/function.php'; // Si nécessaire, décommentez cette ligne pour la connexion

// Récupérer l'ID et le rôle personnel depuis la session
$role = $_SESSION['role'];
$userName = '';

// Récupérer les données du personnel depuis la base de données
$stmt = $connexion->prepare("SELECT * FROM personnel WHERE id = ?");
$stmt->execute([$_SESSION['id']]);
$user = $stmt->fetch(); // Récupère les données du personnel

// Vérifier que l'utilisateur existe
if ($user) {
    $userName = htmlspecialchars($user['nom']); // Stocke le nom du personnel
} else {
    echo "Erreur : Utilisateur non trouvé.";
    exit;
}

// Tableau des titres personnalisés
$pageTitles = [
    'dashboard.php' => 'Tableau de bord',
    'commande.php' => 'Commandes',
    'personnel.php' => 'Personnels',
    'stock.php' => 'Stock',
    'client.php' => 'Clients',
    'produit.php' => 'Produits',
    'categorie.php' => 'Catégories',
    'parametres.php' => 'Paramètres',
    'login.php' => 'Connexion',
    'recuVente.php' => 'Recu'
];

// Obtenir le nom du fichier actuel
$currentFile = basename($_SERVER['PHP_SELF']);

// Titre personnalisé pour la page actuelle
$customTitle = isset($pageTitles[$currentFile]) ? $pageTitles[$currentFile] : 'Page inconnue';
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <title><?php echo $customTitle; ?></title>
    <!-- Lien vers votre fichier CSS -->
    <link rel="stylesheet" href="../public/css/style.css" />
    <!-- Boxicons CDN Link -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <img src="../public/images/G-stock.png" style="height:100px ; width: 100px ;"></img>  <br><br> <br>
            <span class="logo_name">G-Stock</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">
                    <i class="bx bx-grid-alt"></i>
                    <span class="links_name">Dashboard</span>
                </a>
            </li>
            <?php if ($role == 'commercial') : ?>
                <li>
                    <a href="commande.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'commande.php' ? 'active' : '' ?>">
                        <i class="bx bx-user"></i>
                        <span class="links_name">Commande</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($role == 'rh') : ?>
                <li>
                    <a href="personnel.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'personnel.php' ? 'active' : '' ?>">
                        <i class="bx bx-user"></i>
                        <span class="links_name">Accès au personnel</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($role == 'responsable_achat') : ?>
                <li>
                    <a href="stock.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'stock.php' ? 'active' : '' ?>">
                        <i class="bx bx-box"></i>
                        <span class="links_name">Stock</span>
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ($role == 'direction') : ?>
                <li>
                    <a href="commande.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'commande.php' ? 'active' : '' ?>">
                        <i class="bx bx-box"></i>
                        <span class="links_name">Commande</span>
                    </a>
                </li>
                <li>
                    <a href="stock.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'stock.php' ? 'active' : '' ?>">
                        <i class="bx bx-box"></i>
                        <span class="links_name">Stock</span>
                    </a>
                </li>
                <li>
                    <a href="personnel.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'personnel.php' ? 'active' : '' ?>">
                        <i class="bx bx-user"></i>
                        <span class="links_name">Accès au personnel</span>
                    </a>
                </li>
                <li>
                    <a href="client.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'client.php' ? 'active' : '' ?>">
                        <i class="bx bx-list-ul"></i>
                        <span class="links_name">Clients</span>
                    </a>
                </li>
                <li>
                    <a href="produit.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'produit.php' ? 'active' : '' ?>">
                        <i class="bx bx-briefcase"></i>
                        <span class="links_name">Produit</span>
                    </a>
                </li>
                <li>
                    <a href="categorie.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'categorie.php' ? 'active' : '' ?>">
                        <i class="bx bx-briefcase"></i>
                        <span class="links_name">Categorie</span>
                    </a>
                </li>
            <?php endif; ?>
            <li class="log_out">
                <a href="../controller/logout.php">
                    <i class="bx bx-log-out"></i>
                    <span class="links_name">Déconnexion</span>
                </a>
            </li>
        </ul>
    </div>

    <section class="home-section">
        <nav class="hidden-print">
            <div class="sidebar-button">
                <i class="bx bx-menu sidebarBtn"></i>
                <span class="dashboard"><?php echo $customTitle; ?></span>
            </div>

            <div class="profile-details">
                <span class="admin_name" id="profile-name"><?php echo "Bonjour " . $userName; ?></span>
                <i class="bx bx-chevron-down"></i>
                <div class="dropdown-menu" id="dropdown-menu">
                    <a href="parametres.php">Paramètres</a>
                    <a href="../controller/logout.php">Déconnexion</a>
                </div>
            </div>
        </nav>
    </section>

</body>
<script>
    // Cibler les éléments
    const profileName = document.getElementById('profile-name');
    const dropdownMenu = document.getElementById('dropdown-menu');

    // Afficher/Masquer le menu au clic sur le nom
    profileName.addEventListener('click', () => {
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    });

    // Fermer le menu lorsqu'on clique en dehors
    document.addEventListener('click', (e) => {
        if (!document.querySelector('.profile-details').contains(e.target)) {
            dropdownMenu.style.display = 'none';
        }
    });
</script>

</html>
