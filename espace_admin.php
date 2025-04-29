<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f4f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            height: 100vh;
            background-color: #1f2d3d;
            color: white;
            position: fixed;
            width: 260px;
            padding: 30px 20px;
            overflow-y: auto;
        }

        .sidebar h4 {
            font-weight: bold;
            color: #00bcd4;
        }

        .sidebar a,
        .sidebar .dropdown-toggle {
            display: block;
            color: #adb5bd;
            padding: 10px;
            margin: 10px 0;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s, color 0.3s;
        }

        .sidebar a:hover,
        .sidebar .dropdown-toggle:hover {
            background-color: #00bcd4;
            color: white;
        }

        .main-content {
            margin-left: 280px;
            padding: 40px 30px;
        }

        .dashboard-card {
            transition: 0.2s ease-in-out;
            border: none;
            border-left: 5px solid #00bcd4;
        }

        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        }

        .btn-custom {
            background-color: #00bcd4;
            color: white;
        }

        .btn-custom:hover {
            background-color: #0097a7;
        }

        .search-bar {
            margin-bottom: 30px;
        }

        footer {
            background-color: #1f2d3d;
            color: #ccc;
            padding: 20px 0;
            text-align: center;
            margin-top: 60px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4>Admin</h4>
        <p class="mt-4">Connecté : <strong><?php echo $_SESSION['login']; ?></strong></p>

        <a href="espace_admin.php">Accueil</a>

        <div class="dropdown">
            <a class="dropdown-toggle" data-bs-toggle="collapse" href="#etudiantMenu" role="button" aria-expanded="false">Gestion des étudiants</a>
            <div class="collapse" id="etudiantMenu">
                <a href="ajouter_etudiant.php" class="ms-3">Inscrire un étudiant</a>
                <a href="liste_etudiants.php" class="ms-3">Liste des étudiants</a>
                <a href="etudiants_par_filiere.php" class="ms-3">Par filière</a>
                <a href="voir_notes_etudiant.php" class="ms-3">Voir notes</a>
            </div>
        </div>

        <a href="ajouter_filiere.php">Ajouter une filière</a>
        <a href="ajouter_matiere.php">Ajouter une matière</a>
        <a href="ajouter_note.php">Ajouter une note</a>
        <a href="ajouter_admin.php">Ajouter un administrateur</a>
        <a href="modifier_mot_de_passe_admin.php" class="sidebar-link">Modifier mon mot de passe</a>

        <a href="logout.php" class="btn btn-outline-light mt-4">Déconnexion</a>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <!-- Barre de recherche -->
        <div class="d-flex justify-content-end search-bar">
            <form class="d-flex w-50">
                <input class="form-control me-2" type="search" placeholder="Rechercher..." aria-label="Rechercher">
                <button class="btn btn-custom" type="submit">Rechercher</button>
            </form>
        </div>

        <h3 class="mb-4">Tableau de bord administrateur</h3>

        <div class="row g-4">
            <?php
            $actions = [
                ['Inscrire un étudiant', 'ajouter_etudiant.php'],
                ['Ajouter une filière', 'ajouter_filiere.php'],
                ['Ajouter une matière', 'ajouter_matiere.php'],
                ['Ajouter une note', 'ajouter_note.php'],
                ['Liste des étudiants', 'liste_etudiants.php'],
                ['Étudiants par filière', 'etudiants_par_filiere.php'],
                ['Voir notes d’un étudiant', 'voir_notes_etudiant.php'],
                ['Ajouter un administrateur', 'ajouter_admin.php']
            ];

            foreach ($actions as $action) {
                echo '
                <div class="col-md-6 col-lg-4">
                    <div class="card dashboard-card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">'.$action[0].'</h5>
                            <a href="'.$action[1].'" class="btn btn-custom">Accéder</a>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            &copy; <?php echo date('Y'); ?> US | Plateforme de gestion des notes - Tous droits réservés.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>