<?php
$servername = "localhost";
$username = "root";
$password = ""; // à modifier si nécessaire
$dbname = "uvs_etudiant";

// Connexion à MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>