<?php
session_start();
include 'connexion.php'; // Fichier qui contient la connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Préparation de la requête
    $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE login = ? AND mot_de_passe = ?");
    $stmt->bind_param("ss", $login, $mot_de_passe);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérification de l'utilisateur
    if ($result->num_rows == 1) {
        $utilisateur = $result->fetch_assoc();
        $_SESSION['login'] = $utilisateur['login'];
        $_SESSION['role'] = $utilisateur['role'];

        // Redirection selon le rôle
        if ($utilisateur['role'] == 'admin') {
            header("Location: espace_admin.php");
        } else {
            header("Location: espace_etudiant.php");
        }
        exit();
    } else {
        echo "<script>alert('Identifiants incorrects');window.location.href='index.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>