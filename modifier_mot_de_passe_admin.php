<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "uvs_etudiant");
if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = $_SESSION['login'];
    $ancien      = mysqli_real_escape_string($conn, $_POST['ancien_mdp']);
    $nouveau     = mysqli_real_escape_string($conn, $_POST['nouveau_mdp']);
    $confirmation= mysqli_real_escape_string($conn, $_POST['confirmation_mdp']);

    if ($nouveau !== $confirmation) {
        $message = "<div class='alert alert-warning'>Les nouveaux mots de passe ne correspondent pas.</div>";
    } else {
        $sql = "SELECT mot_de_passe FROM utilisateur WHERE login = '$login' AND role = 'admin'";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);

        if ($row && password_verify($ancien, $row['mot_de_passe'])) {
            $hash = password_hash($nouveau, PASSWORD_DEFAULT);
            $upd  = "UPDATE utilisateur SET mot_de_passe = '$hash' WHERE login = '$login'";
            if (mysqli_query($conn, $upd)) {
                $message = "<div class='alert alert-success'>Mot de passe mis à jour avec succès.</div>";
            } else {
                $message = "<div class='alert alert-danger'>Erreur lors de la mise à jour.</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>Ancien mot de passe incorrect.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier mot de passe - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f1f4f9; font-family: 'Segoe UI', sans-serif; }
    .sidebar {
      height: 100vh; width: 260px; position: fixed;
      background-color: #1f2d3d; padding: 30px 20px; color: white;
    }
    .sidebar h4 { color: #00bcd4; }
    .sidebar a { display: block; color: #adb5bd; padding: 10px; margin: 10px 0; text-decoration: none; border-radius: 5px; }
    .sidebar a:hover { background-color: #00bcd4; color: white; }
    .main-content { margin-left: 280px; padding: 40px 30px; }
    
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
    <h4>UVS Admin</h4>
    <p class="mt-4">Connecté : <strong><?php echo $_SESSION['login']; ?></strong></p>
    <a href="espace_admin.php">Accueil</a>
    <a href="modifier_mot_de_passe_admin.php" style="background-color:#00bcd4;color:white;">Modifier mot de passe</a>
    <a href="logout.php" class="btn btn-outline-light mt-4">Déconnexion</a>
  </div>

  <!-- Main content -->
  <div class="main-content">
    <h3 class="mb-4">Modifier mon mot de passe</h3>
    <?php echo $message; ?>

    <form method="POST" class="bg-white shadow-sm p-4 rounded w-50">
      <div class="mb-3">
        <label for="ancien_mdp" class="form-label">Ancien mot de passe</label>
        <input type="password" id="ancien_mdp" name="ancien_mdp" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="nouveau_mdp" class="form-label">Nouveau mot de passe</label>
        <input type="password" id="nouveau_mdp" name="nouveau_mdp" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="confirmation_mdp" class="form-label">Confirmer nouveau mot de passe</label>
        <input type="password" id="confirmation_mdp" name="confirmation_mdp" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Valider</button>
    </form>
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