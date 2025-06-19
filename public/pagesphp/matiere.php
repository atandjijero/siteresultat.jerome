<?php
include("config.php"); // $pdo est censé être défini ici

$nom_matiere = htmlspecialchars($_POST['nom_matiere']);
$filiere_id = intval($_POST['filiere_id']);

// Vérifier si la filière existe
$query_filiere = "SELECT id FROM filieres WHERE id = :id";
$stmt_filiere = $pdo->prepare($query_filiere);
$stmt_filiere->execute([':id' => $filiere_id]);

if ($stmt_filiere->rowCount() == 0) {
    die("<p class='alert alert-danger text-center'>Erreur : Filière non trouvée.</p>");
}

// Vérifier si la matière existe déjà pour cette filière
$query_check = "SELECT id FROM matieres WHERE nom_matiere = :nom AND filiere_id = :filiere_id";
$stmt_check = $pdo->prepare($query_check);
$stmt_check->execute([
    ':nom' => $nom_matiere,
    ':filiere_id' => $filiere_id
]);

if ($stmt_check->rowCount() > 0) {
    die("<p class='alert alert-danger text-center'>Erreur : Cette matière existe déjà pour cette filière.</p>");
}

// Insérer la nouvelle matière
$query_insert = "INSERT INTO matieres (nom_matiere, filiere_id) VALUES (:nom_matiere, :filiere_id)";
$stmt_insert = $pdo->prepare($query_insert);
$result = $stmt_insert->execute([
    ':nom_matiere' => $nom_matiere,
    ':filiere_id' => $filiere_id
]);

if ($result) {
    echo "<p class='alert alert-success text-center'>Matière ajoutée avec succès !</p>";
} else {
    echo "<p class='alert alert-danger text-center'>Erreur lors de l'ajout.</p>";
}
?>