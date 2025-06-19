<?php
include("config.php"); // Ce fichier doit initialiser $pdo comme instance de PDO

$nom = htmlspecialchars($_POST['nom']);
$matricule = htmlspecialchars($_POST['matricule']);
$filiere_id = intval($_POST['filiere_id']);

try {
    // Vérification de la filière
    $stmt = $pdo->prepare("SELECT id FROM filieres WHERE id = ?");
    $stmt->execute([$filiere_id]);

    if ($stmt->rowCount() === 0) {
        die("<p class='alert alert-danger text-center'>Erreur : Filière non trouvée.</p>");
    }

    // Vérification de l'unicité du matricule
    $stmt = $pdo->prepare("SELECT matricule FROM etudiants WHERE matricule = ?");
    $stmt->execute([$matricule]);

    if ($stmt->rowCount() > 0) {
        die("<p class='alert alert-danger text-center'>Erreur : Matricule déjà utilisé.</p>");
    }

    // Insertion de l'étudiant
    $stmt = $pdo->prepare("INSERT INTO etudiants (matricule, nom, filiere_id) VALUES (?, ?, ?)");
    $result = $stmt->execute([$matricule, $nom, $filiere_id]);

    if ($result) {
        echo "<p class='alert alert-success text-center'>Étudiant ajouté avec succès !</p>";
    } else {
        echo "<p class='alert alert-danger text-center'>Erreur lors de l'ajout.</p>";
    }

} catch (PDOException $e) {
    echo "<p class='alert alert-danger text-center'>Erreur PDO : " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>