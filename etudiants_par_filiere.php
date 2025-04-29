<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "uvs_etudiant");
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$filiere_query = $conn->query("SELECT DISTINCT nomfiliere FROM filiere");

$etudiants = [];
if (isset($_POST['filiere']) && !empty($_POST['filiere'])) {
    $selected_filiere = $conn->real_escape_string($_POST['filiere']);
    $result = $conn->query("SELECT * FROM etudiant WHERE filiere = '$selected_filiere'");
    while ($row = $result->fetch_assoc()) {
        $etudiants[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Étudiants par filière</title>
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

<!-- Main -->
<div class="main-content">
    <h3 class="mb-4">Afficher les étudiants par filière</h3>

    <form method="POST" class="row g-3 mb-4">
        <div class="col-md-6">
            <label for="filiere" class="form-label">Choisir une filière :</label>
            <select name="filiere" class="form-select" required>
                <option value="">-- Sélectionner une filière --</option>
                <?php while ($filiere = $filiere_query->fetch_assoc()): ?>
                    <option value="<?= $filiere['nomfiliere']; ?>" 
                        <?= (isset($selected_filiere) && $selected_filiere == $filiere['nomfiliere']) ? 'selected' : ''; ?>>
                        <?= $filiere['nomfiliere']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Afficher</button>
        </div>
    </form>

    <?php if (!empty($etudiants)): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>INE</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Sexe</th>
                        <th>ENO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($etudiants as $etudiant): ?>
                        <tr>
                            <td><?= $etudiant['ine']; ?></td>
                            <td><?= ucfirst($etudiant['nom']); ?></td>
                            <td><?= ucfirst($etudiant['prenom']); ?></td>
                            <td><?= $etudiant['email']; ?></td>
                            <td><?= $etudiant['telephone']; ?></td>
                            <td><?= $etudiant['sexe']; ?></td>
                            <td><?= $etudiant['eno']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php elseif (isset($selected_filiere)): ?>
        <div class="alert alert-warning">Aucun étudiant trouvé pour la filière <strong><?= htmlspecialchars($selected_filiere); ?></strong>.</div>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer>
    &copy; <?php echo date('Y'); ?> US - Plateforme de gestion des notes
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>