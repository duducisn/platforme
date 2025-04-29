<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Accueil - US Notes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h1 class="text-center mb-4">Bienvenue sur la plateforme de gestion des notes</h1>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <form action="login.php" method="post" class="card p-4 shadow">
          <h4 class="mb-3">Connexion</h4>
          <div class="mb-3">
            <label for="login" class="form-label">Email ou Matricule</label>
            <input type="text" class="form-control" name="login" required>
          </div>
          <div class="mb-3">
            <label for="mot_de_passe" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" name="mot_de_passe" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Se connecter</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>