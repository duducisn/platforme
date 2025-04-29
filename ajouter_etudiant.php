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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ine = $conn->real_escape_string($_POST['ine']);
    $nom = $conn->real_escape_string($_POST['nom']);
    $prenom = $conn->real_escape_string($_POST['prenom']);
    $email = $conn->real_escape_string($_POST['email']);
    $telephone = $conn->real_escape_string($_POST['telephone']);
    $sexe = $conn->real_escape_string($_POST['sexe']);
    $filiere = $conn->real_escape_string($_POST['filiere']);
    $eno = $conn->real_escape_string($_POST['eno']);

    $sql = "INSERT INTO etudiant (ine, nom, prenom, email, telephone, sexe, filiere, eno) 
            VALUES ('$ine', '$nom', '$prenom', '$email', '$telephone', '$sexe', '$filiere', '$eno')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Étudiant ajouté avec succès!";
    } else {
        $error_message = "Erreur : " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un étudiant</title>
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
    <h4> Admin</h4>
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
    <h3 class="mb-4">Ajouter un étudiant</h3>

    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?= $success_message ?></div>
    <?php elseif (isset($error_message)): ?>
        <div class="alert alert-danger"><?= $error_message ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="ine" class="form-label">Numéro INE</label>
                <input type="text" name="ine" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="telephone" class="form-label">Numéro de téléphone</label>
                <input type="tel" name="telephone" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="sexe" class="form-label">Sexe</label>
                <select name="sexe" class="form-select" required>
                    <option value="masculin">Masculin</option>
                    <option value="feminin">Féminin</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="filiere" class="form-label">Filière</label>
                <select name="filiere" class="form-select" required>
                    <option value="AGN">AGN</option>
                    <option value="CD">CD</option>
                    <option value="EPS">EPS</option>
                    <option value="MAI">MAI</option>
                    <option value="MIC">MIC</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="eno" class="form-label">Lieu de naissance (ENO)</label>
                <select name="eno" class="form-select" required>
                    <option value="Dakar">Dakar</option>
                    <option value="Diourbel">Diourbel</option>
                    <option value="Guédiawaye">Guédiawaye</option>
                    <option value="Podor">Podor</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-success mt-4">Ajouter l'étudiant</button>
    </form>
</div>

<!-- Footer -->
<footer>
    &copy; <?php echo date('Y'); ?> US - Plateforme de gestion des notes
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>