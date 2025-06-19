<?php
include("config.php"); // $pdo déjà défini ici

$nom_filiere = htmlspecialchars($_POST['nom_filiere']);

// Vérifier si la filière existe déjà
$query_check = "SELECT id FROM filieres WHERE nom_filiere = :nom_filiere";
$stmt_check = $pdo->prepare($query_check);
$stmt_check->execute([':nom_filiere' => $nom_filiere]);

if ($stmt_check->rowCount() > 0) {
    die("<p class='alert alert-danger text-center'>Erreur : La filière existe déjà.</p>");
}

// Insérer la nouvelle filière
$query_insert = "INSERT INTO filieres (nom_filiere) VALUES (:nom_filiere)";
$stmt_insert = $pdo->prepare($query_insert);
$result = $stmt_insert->execute([':nom_filiere' => $nom_filiere]);

if ($result) {
    echo "<p class='alert alert-success text-center'>Filière ajoutée avec succès !</p>";
} else {
    echo "<p class='alert alert-danger text-center'>Erreur lors de l'ajout.</p>";
}
?>