<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'etudiant') {
    header("Location: index.php");
    exit();
}

// Connexion à la base
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
        // Récupérer le hash dans utilisateur
        $sql  = "SELECT mot_de_passe FROM utilisateur WHERE login = '$login' AND role = 'etudiant'";
        $res  = mysqli_query($conn, $sql);
        $row  = mysqli_fetch_assoc($res);

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
  <title>Modifier mon mot de passe</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f5f7fa; font-family: 'Segoe UI', sans-serif; }
    .container {
      max-width: 600px;
      margin: 80px auto;
      background: white;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
  <div class="container">
    <h3 class="mb-4 text-center">Modifier mon mot de passe</h3>
    <?php echo $message; ?>
    <form method="POST">
      <div class="mb-3">
        <label for="ancien_mdp" class="form-label">Ancien mot de passe</label>
        <input type="password" id="ancien_mdp" name="ancien_mdp" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="nouveau_mdp" class="form-label">Nouveau mot de passe</label>
        <input type="password" id="nouveau_mdp" name="nouveau_mdp" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="confirmation_mdp" class="form-label">Confirmer le nouveau mot de passe</label>
        <input type="password" id="confirmation_mdp" name="confirmation_mdp" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Valider</button>
    </form>
  </div>
  <footer class="text-center mt-5">
    &copy; <?php echo date('Y'); ?> US – Plateforme de gestion des notes
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>