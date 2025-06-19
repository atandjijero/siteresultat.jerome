<?php
include("config.php"); // suppose que $pdo est déjà défini ici

$nom_etudiant = trim(htmlspecialchars($_POST['nom_etudiant']));
$nom_matiere = trim(htmlspecialchars($_POST['nom_matiere']));
$note_devoir = floatval($_POST['note_devoir']);
$note_examen = floatval($_POST['note_examen']);

// Récupération de l'étudiant
$query_etudiant = "SELECT matricule FROM etudiants WHERE nom = :nom";
$stmt_etudiant = $pdo->prepare($query_etudiant);
$stmt_etudiant->execute([':nom' => $nom_etudiant]);
$etudiant = $stmt_etudiant->fetch(PDO::FETCH_ASSOC);

if (!$etudiant) {
    die("<p class='alert alert-danger'>Erreur : L'étudiant '$nom_etudiant' n'existe pas.</p>");
}
$etudiant_id = $etudiant['matricule'];

// Récupération de la matière
$query_matiere = "SELECT id FROM matieres WHERE nom_matiere = :matiere";
$stmt_matiere = $pdo->prepare($query_matiere);
$stmt_matiere->execute([':matiere' => $nom_matiere]);
$matiere = $stmt_matiere->fetch(PDO::FETCH_ASSOC);

if (!$matiere) {
    die("<p class='alert alert-danger'>Erreur : La matière '$nom_matiere' n'existe pas.</p>");
}
$matiere_id = $matiere['id'];

// Calcul des notes
$moyenne = ($note_devoir * 0.4) + ($note_examen * 0.6);
$valide = ($moyenne >= 10);

// Insertion de la note
$query_insert = "INSERT INTO notes (etudiant_id, matiere_id, note_devoir, note_examen, moyenne, valide)
                 VALUES (:etudiant_id, :matiere_id, :note_devoir, :note_examen, :moyenne, :valide)";
$stmt_insert = $pdo->prepare($query_insert);
$result = $stmt_insert->execute([
    ':etudiant_id' => $etudiant_id,
    ':matiere_id' => $matiere_id,
    ':note_devoir' => $note_devoir,
    ':note_examen' => $note_examen,
    ':moyenne' => $moyenne,
    ':valide' => $valide,
]);

if ($result) {
    echo "<p class='alert alert-success text-center'>Note ajoutée avec succès ! Moyenne : $moyenne</p>";
} else {
    echo "<p class='alert alert-danger text-center'>Erreur lors de l'ajout.</p>";
}
?>