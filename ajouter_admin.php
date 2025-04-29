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
    die("Connexion échouée : " . $conn->connect_error);
}

// Traitement formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST['login']);
    $mot_de_passe = trim($_POST['mot_de_passe']);
    $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
    $role = 'admin'; // Par défaut, le rôle est administrateur

    if (!empty($login) && !empty($mot_de_passe)) {
        // Vérifier si l'email est déjà utilisé
        $check = $conn->prepare("SELECT * FROM utilisateur WHERE login = ?");
        $check->bind_param("s", $login);
        $check->execute();
        $res = $check->get_result();

        if ($res->num_rows > 0) {
            $error = "Cet administrateur existe déjà.";
        } else {
            $stmt = $conn->prepare("INSERT INTO utilisateur (login, mot_de_passe, role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $login, $mot_de_passe_hash, $role);
            if ($stmt->execute()) {
                $success = "Administrateur ajouté avec succès.";
            } else {
                $error = "Erreur lors de l'ajout de l'administrateur.";
            }
            $stmt->close();
        }

        $check->close();
    } else {
        $error = "Tous les champs sont requis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un administrateur - UVS Admin</title>
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

<!-- Main Content -->
<div class="main-content">
    <h3 class="mb-4">Ajouter un administrateur</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="ajouter_admin.php" class="bg-white shadow-sm p-4 rounded w-50">
        <div class="mb-3">
            <label for="login" class="form-label">Email de l'administrateur</label>
            <input type="email" class="form-control" name="login" id="login" required>
        </div>
        <div class="mb-3">
            <label for="mot_de_passe" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" name="mot_de_passe" id="mot_de_passe" required>
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