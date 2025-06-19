<?php
ob_start(); // Pour éviter toute sortie avant le PDF

require('fpdf.php');
include("config.php"); // Connexion PDO PostgreSQL

$matricule = htmlspecialchars($_GET['matricule']);
$filiere_id = intval($_GET['filiere_id']);

// Vérifier l'existence de l'étudiant
$query_etudiant = "SELECT e.matricule, e.nom, f.nom_filiere 
                   FROM etudiants e 
                   JOIN filieres f ON e.filiere_id = f.id 
                   WHERE e.matricule = :matricule AND f.id = :filiere_id";
$stmt_etudiant = $pdo->prepare($query_etudiant);
$stmt_etudiant->execute([
    ':matricule' => $matricule,
    ':filiere_id' => $filiere_id
]);
$etudiant = $stmt_etudiant->fetch(PDO::FETCH_ASSOC);

if (!$etudiant) {
    die("Erreur : Étudiant non trouvé.");
}

$nom_etudiant = $etudiant['nom'];
$nom_filiere = $etudiant['nom_filiere'];

// Récupérer les notes
$query_notes = "SELECT m.nom_matiere, n.note_devoir, n.note_examen, n.moyenne, n.valide 
                FROM notes n 
                JOIN matieres m ON n.matiere_id = m.id 
                WHERE n.etudiant_id = :matricule";
$stmt_notes = $pdo->prepare($query_notes);
$stmt_notes->execute([':matricule' => $matricule]);
$notes = $stmt_notes->fetchAll(PDO::FETCH_ASSOC);

// Calcul de moyenne
$moyenne_generale = 0;
$total_matieres = count($notes);

// Création du PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetTextColor(0, 51, 102);
$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(190, 10, "Résultats de $nom_etudiant ($matricule)", 0, 1, 'C', true);
$pdf->Cell(190, 10, "Filière : $nom_filiere", 0, 1, 'C', true);
$pdf->Ln(10);

// En-tête du tableau
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(0, 51, 102);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(50, 10, "Matière", 1, 0, 'C', true);
$pdf->Cell(30, 10, "Devoir", 1, 0, 'C', true);
$pdf->Cell(30, 10, "Examen", 1, 0, 'C', true);
$pdf->Cell(30, 10, "Moyenne", 1, 0, 'C', true);
$pdf->Cell(30, 10, "Validé", 1, 1, 'C', true);

// Lignes de notes
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0);

foreach ($notes as $row) {
    $valide = ($row['valide'] === 't' || $row['valide'] === true) ? "Oui" : "Non";
    $pdf->SetFillColor(240, 240, 240);
    $pdf->Cell(50, 10, $row['nom_matiere'], 1, 0, 'C', true);
    $pdf->Cell(30, 10, $row['note_devoir'], 1, 0, 'C', true);
    $pdf->Cell(30, 10, $row['note_examen'], 1, 0, 'C', true);
    $pdf->Cell(30, 10, $row['moyenne'], 1, 0, 'C', true);
    $pdf->Cell(30, 10, $valide, 1, 1, 'C', true);
    
    $moyenne_generale += $row['moyenne'];
}

if ($total_matieres > 0) {
    $moyenne_generale /= $total_matieres;
}

// Attribution de la mention
$mention = "Insuffisant";
if ($moyenne_generale >= 16) $mention = "Très Bien";
elseif ($moyenne_generale >= 14) $mention = "Bien";
elseif ($moyenne_generale >= 12) $mention = "Assez Bien";
elseif ($moyenne_generale >= 10) $mention = "Passable";

// Section résumé
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 51, 102);
$pdf->Cell(190, 10, "📊 Moyenne Générale : " . round($moyenne_generale, 2), 0, 1, 'C', true);
$pdf->Cell(190, 10, "🏅 Mention : $mention", 0, 1, 'C', true);

// Pied de page
$pdf->Ln(10);
$pdf->SetTextColor(100, 100, 100);
$pdf->Cell(190, 10, "🔹 Généré automatiquement par le système 🔹", 0, 1, 'C');

ob_end_clean(); // Stoppe toute sortie avant génération PDF
$pdf->Output("resultat_$matricule.pdf", 'D');
?>