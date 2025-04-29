<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$success = $error = "";

// Connexion à la base
$conn = new mysqli("localhost", "root", "", "uvs_etudiant");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Récupération des étudiants
$etudiants = $conn->query("SELECT ine, nom, prenom FROM etudiant");

// Récupération des matières
$matieres = $conn->query("SELECT nom_matiere FROM matiere");

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ine = $_POST['ine'];
    $matiere = $_POST['nom_matiere'];
    $note = $_POST['note'];

    if (!empty($ine) && !empty($matiere) && is_numeric($note)) {
        $stmt = $conn->prepare("INSERT INTO note (ine, nom_matiere, note) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $ine, $matiere, $note);

        if ($stmt->execute()) {
            $success = "Note ajoutée avec succès.";
        } else {
            $error = "Erreur lors de l'ajout.";
        }
    } else {
        $error = "Tous les champs sont obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une note -  Admin</title>
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
    <h3 class="mb-4">Ajouter une note</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="" class="bg-white shadow-sm p-4 rounded w-50">
        <div class="mb-3">
            <label for="ine" class="form-label">Étudiant</label>
            <select class="form-select" name="ine" id="ine" required>
                <option value="">-- Sélectionner un étudiant --</option>
                <?php while($etudiant = $etudiants->fetch_assoc()): ?>
                    <option value="<?php echo $etudiant['ine']; ?>">
                        <?php echo $etudiant['ine'] . ' - ' . strtoupper($etudiant['nom']) . ' ' . ucfirst($etudiant['prenom']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="nom_matiere" class="form-label">Matière</label>
            <select class="form-select" name="nom_matiere" id="nom_matiere" required>
                <option value="">-- Sélectionner une matière --</option>
                <?php while($matiere = $matieres->fetch_assoc()): ?>
                    <option value="<?php echo $matiere['nom_matiere']; ?>"><?php echo ucfirst($matiere['nom_matiere']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="note" class="form-label">Note (/20)</label>
            <input type="number" step="0.01" min="0" max="20" class="form-control" name="note" id="note" required>
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