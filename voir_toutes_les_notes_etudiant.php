<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'etudiant') {
    header("Location: index.php");
    exit();
}

$login = $_SESSION['login'];
$link = mysqli_connect("localhost", "root", "", "uvs_etudiant");
if (!$link) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

$query = "SELECT * FROM etudiant WHERE email = '$login'";
$result = mysqli_query($link, $query);
$etudiant = mysqli_fetch_assoc($result);

$ine = $etudiant['ine'];
$query_notes = "SELECT * FROM note WHERE ine = '$ine'";
$result_notes = mysqli_query($link, $query_notes);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .sidebar {
            height: 100vh;
            background-color: #2c3e50;
            color: white;
            position: fixed;
            width: 250px;
            padding: 30px 20px;
        }

        .sidebar h4 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .sidebar p {
            font-size: 1.1rem;
            margin-bottom: 30px;
        }

        .sidebar-link {
            display: block;
            color: #dfe6e9;
            padding: 12px;
            margin: 10px 0;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1rem;
        }

        .sidebar-link:hover {
            background-color: #00bcd4;
            color: white;
        }

        .dropdown-menu {
            background-color: #34495e;
        }

        .sidebar-dropdown-item {
            color: #dfe6e9;
            padding: 10px;
            font-size: 1rem;
        }

        .sidebar-dropdown-item:hover {
            background-color: #1abc9c;
            color: white;
        }

        .main-content {
            margin-left: 280px;
            padding: 40px 30px;
        }

        .carousel-inner img,
        .carousel-inner video {
            height: 350px;
            object-fit: contain;
            background-color: white;
            padding: 20px;
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
    <h4>Espace étudiant</h4>
    <p>Connecté : <strong><?php echo $_SESSION['login']; ?></strong></p>

    <a href="espace_etudiant.php" class="sidebar-link">Accueil</a>

    <div class="dropdown">
        <a class="btn btn-dark dropdown-toggle w-100 text-start sidebar-link" href="#" id="dropdownNotes" data-bs-toggle="dropdown" aria-expanded="false">
            Mes notes
        </a>
        <ul class="dropdown-menu w-100" aria-labelledby="dropdownNotes">
            <li><a class="dropdown-item" href="voir_notes_etudiant.php">Voir toutes mes notes</a></li>
            <li><a class="dropdown-item" href="voir_notes_par_matiere.php">Voir mes notes par matière</a></li>
        </ul>
    </div>

    <a href="modifie_mot_de_passe.php" class="sidebar-link">Modifier mon mot de passe</a>
    <a href="logout.php" class="btn btn-outline-light mt-4 sidebar-link">Déconnexion</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <h3 class="mb-4">Mes notes</h3>
    
    <!-- Tableau des notes -->
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Matière</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($note = mysqli_fetch_assoc($result_notes)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($note['nom_matiere']); ?></td>
                    <td><?php echo htmlspecialchars($note['note']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
  <!-- Carrousel mixte image + vidéo -->
  <div id="carouselEtudiant" class="carousel slide mt-5" data-bs-ride="carousel">
        <div class="carousel-inner rounded shadow">
            <div class="carousel-item active">
                <img src="https://cdn-icons-png.flaticon.com/512/1995/1995574.png" class="d-block w-100" alt="Image 1">
            </div>
            <div class="carousel-item">
                <video class="d-block w-100" autoplay loop muted>
                    <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
                    Votre navigateur ne supporte pas les vidéos.
                </video>
            </div>
            <div class="carousel-item">
                <img src="https://cdn-icons-png.flaticon.com/512/1995/1995533.png" class="d-block w-100" alt="Image 2">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselEtudiant" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselEtudiant" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

</div>


<!-- Footer -->
<footer>
    &copy; <?php echo date('Y'); ?> US - Plateforme de gestion des notes
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>