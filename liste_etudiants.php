<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "uvs_etudiant");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$etudiants = $conn->query("SELECT * FROM etudiant ORDER BY nom");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des étudiants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f7fa; font-family: 'Segoe UI', sans-serif; }
        .sidebar {
            height: 100vh;
            background-color: #1f2d3d;
            color: white;
            position: fixed;
            width: 260px;
            padding: 30px 20px;
        }
        .sidebar h4 { color: #00bcd4; }
        .sidebar a,
        .sidebar .dropdown-toggle {
            display: block;
            color: #adb5bd;
            padding: 10px;
            margin: 10px 0;
            text-decoration: none;
            border-radius: 5px;
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
        footer {
            background-color: #1f2d3d;
            color: #ccc;
            padding: 20px 0;
            text-align: center;
            margin-top: 60px;
        }
        .search-bar {
            margin-bottom: 20px;
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
        <a class="dropdown-toggle" data-bs-toggle="collapse" href="#etudiantMenu" role="button">Gestion des étudiants</a>
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
    <a href="logout.php" class="btn btn-outline-light mt-4">Déconnexion</a>
</div>

<!-- Contenu principal -->
<div class="main-content">
    <h3 class="mb-4">Liste des étudiants</h3>

    <div class="search-bar">
        <input type="text" id="searchInput" class="form-control" placeholder="Rechercher par nom, prénom ou INE...">
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="etudiantTable">
            <thead class="table-dark">
                <tr>
                    <th>INE</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Sexe</th>
                    <th>Filière</th>
                    <th>ENO</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $etudiants->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['ine']; ?></td>
                        <td><?= ucfirst($row['nom']); ?></td>
                        <td><?= ucfirst($row['prenom']); ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['telephone']; ?></td>
                        <td><?= $row['sexe']; ?></td>
                        <td><?= $row['filiere']; ?></td>
                        <td><?= $row['eno']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Footer -->
<footer>
    &copy; <?php echo date('Y'); ?> US - Plateforme de gestion des notes
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Recherche dynamique dans la table
    document.getElementById("searchInput").addEventListener("keyup", function () {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll("#etudiantTable tbody tr");
        rows.forEach(row => {
            let show = false;
            row.querySelectorAll("td").forEach(td => {
                if (td.innerText.toLowerCase().includes(value)) show = true;
            });
            row.style.display = show ? "" : "none";
        });
    });
</script>
</body>
</html>