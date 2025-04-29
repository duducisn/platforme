<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$success = $error = "";

// Connexion
$conn = new mysqli("localhost", "root", "", "uvs_etudiant");
if ($conn->connect_error) {
    die("Erreur : " . $conn->connect_error);
}

// Récupération des filières
$filiere_result = $conn->query("SELECT * FROM filiere");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nom_matiere']);
    $filiere = $_POST['filiere'];
    $semestre = $_POST['semestre'];

    if ($nom && $filiere && $semestre) {
        $stmt = $conn->prepare("INSERT INTO matiere (nom_matiere, filiere, semestre) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nom, $filiere, $semestre);
        if ($stmt->execute()) {
            $success = "Matière ajoutée avec succès.";
        } else {
            $error = "Erreur lors de l'ajout.";
        }
    } else {
        $error = "Tous les champs sont requis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une matière</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f1f4f9; font-family: 'Segoe UI', sans-serif; }
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
        .btn-custom {
            background-color: #00bcd4;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0097a7;
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

<!-- Contenu principal -->
<div class="main-content">
    <h3 class="mb-4">Ajouter une matière</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" class="bg-white shadow-sm p-4 rounded w-50">
        <div class="mb-3">
            <label for="nom_matiere" class="form-label">Nom de la matière</label>
            <input type="text" class="form-control" name="nom_matiere" id="nom_matiere" required>
        </div>
        <div class="mb-3">
            <label for="filiere" class="form-label">Filière</label>
            <select class="form-select" name="filiere" id="filiere" required>
                <option value="">-- Sélectionner --</option>
                <?php while ($row = $filiere_result->fetch_assoc()): ?>
                    <option value="<?= $row['nomfiliere']; ?>"><?= $row['nomfiliere']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="semestre" class="form-label">Semestre</label>
            <select class="form-select" name="semestre" id="semestre" required>
                <option value="">-- Sélectionner --</option>
                <option value="1">Semestre 1</option>
                <option value="2">Semestre 2</option>
            </select>
        </div>
        <div class="text-end">
            <button type="submit" class="btn btn-custom">Ajouter</button>
        </div>
    </form>
</div>

<!-- Footer -->
<footer>
    &copy; <?php echo date('Y'); ?> US - Plateforme de gestion des notes
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>