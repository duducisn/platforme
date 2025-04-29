<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "uvs_etudiant");
if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

$note = null;
$matiere = null;
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ine'], $_POST['nom_matiere'])) {
    $ine = mysqli_real_escape_string($conn, $_POST['ine']);
    $nom_matiere = mysqli_real_escape_string($conn, $_POST['nom_matiere']);

    // Rechercher la matière
    $matiereQuery = "SELECT * FROM matiere WHERE nom_matiere = '$nom_matiere'";
    $matiereResult = mysqli_query($conn, $matiereQuery);
    $matiere = mysqli_fetch_assoc($matiereResult);

    if ($matiere) {
        $id_matiere = $matiere['id'];
        $noteQuery = "SELECT note FROM note WHERE ine = '$ine' AND id_matiere = $id_matiere";
        $noteResult = mysqli_query($conn, $noteQuery);
        $note = mysqli_fetch_assoc($noteResult);

        if (!$note) {
            $message = "Aucune note trouvée pour cet étudiant dans cette matière.";
        }
    } else {
        $message = "Matière introuvable.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de note par INE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            max-width: 650px;
            margin-top: 80px;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
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

<div class="container">
    <h3 class="mb-4 text-center">Rechercher une note par INE et matière</h3>

    <form method="POST" class="mb-4">
        <div class="mb-3">
            <label for="ine" class="form-label">INE de l'étudiant</label>
            <input type="text" name="ine" id="ine" class="form-control" placeholder="Ex : E123456789" required>
        </div>
        <div class="mb-3">
            <label for="nom_matiere" class="form-label">Nom de la matière</label>
            <input type="text" name="nom_matiere" id="nom_matiere" class="form-control" placeholder="Ex : Algorithmique" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Rechercher</button>
    </form>

    <?php if ($matiere && $note): ?>
        <div class="alert alert-success">
            <strong><?php echo htmlspecialchars($matiere['nom_matiere']); ?></strong> : <?php echo $note['note']; ?>/20
        </div>
    <?php elseif (!empty($message)): ?>
        <div class="alert alert-warning"><?php echo $message; ?></div>
    <?php endif; ?>
</div>

<footer>
    &copy; <?php echo date('Y'); ?> UVS - Plateforme de gestion des notes
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>