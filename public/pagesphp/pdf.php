<?php
ob_start(); // Démarrer la temporisation de sortie

require('fpdf.php');
include("config.php"); // Connexion à la base PostgreSQL

$matricule = htmlspecialchars($_GET['matricule'] ?? '');
$filiere_id = intval($_GET['filiere_id'] ?? 0);

// Vérifier l'existence de l'étudiant
$query = "SELECT e.matricule, e.nom, f.nom_filiere
          FROM etudiants e
          JOIN filieres f ON e.filiere_id = f.id
          WHERE e.matricule = :matricule AND f.id = :filiere_id";
$stmt = $pdo->prepare($query);
$stmt->execute([
    ':matricule' => $matricule,
    ':filiere_id' => $filiere_id
]);
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$etudiant) {
    ob_end_clean();
    die("Erreur : Étudiant non trouvé.");
}

$nom = $etudiant['nom'];
$filiere = $etudiant['nom_filiere'];

// Récupération des notes
$sql_notes = "SELECT m.nom_matiere, n.note_devoir, n.note_examen, n.moyenne, n.valide 
              FROM notes n 
              JOIN matieres m ON n.matiere_id = m.id 
              WHERE n.etudiant_id = :matricule";
$req = $pdo->prepare($sql_notes);
$req->execute([':matricule' => $matricule]);
$notes = $req->fetchAll(PDO::FETCH_ASSOC);

// Création du PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetTextColor(0, 51, 102);
$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(190, 10, "Résultats de $nom ($matricule)", 0, 1, 'C', true);
$pdf->Cell(190, 10, "Filière : $filiere", 0, 1, 'C', true);
$pdf->Ln(10);

// En-têtes tableau
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(0, 51, 102);
$pdf->SetTextColor(255);
$headers = ["Matière", "Devoir", "Examen", "Moyenne", "Validé"];
$widths = [50, 30, 30, 30, 30];
foreach ($headers as $i => $h) {
    $pdf->Cell($widths[$i], 10, $h, 1, 0, 'C', true);
}
$pdf->Ln();

// Contenu des notes
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0);
$moyenne_generale = 0;
$total = count($notes);

foreach ($notes as $n) {
    $valide = ($n['valide'] === 't' || $n['valide'] === true) ? "Oui" : "Non";
    $pdf->SetFillColor(245, 245, 245);
    $pdf->Cell(50, 10, $n['nom_matiere'], 1, 0, 'C', true);
    $pdf->Cell(30, 10, $n['note_devoir'], 1, 0, 'C', true);
    $pdf->Cell(30, 10, $n['note_examen'], 1, 0, 'C', true);
    $pdf->Cell(30, 10, $n['moyenne'], 1, 0, 'C', true);
    $pdf->Cell(30, 10, $valide, 1, 1, 'C', true);

    $moyenne_generale += floatval($n['moyenne']);
}

// Moyenne générale
$moyenne = ($total > 0) ? round($moyenne_generale / $total, 2) : 0;
$mention = "Insuffisant";
if ($moyenne >= 16) $mention = "Très Bien";
elseif ($moyenne >= 14) $mention = "Bien";
elseif ($moyenne >= 12) $mention = "Assez Bien";
elseif ($moyenne >= 10) $mention = "Passable";

// Résumé
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 51, 102);
$pdf->Cell(190, 10, "📊 Moyenne Générale : $moyenne", 0, 1, 'C', true);
$pdf->Cell(190, 10, "🏅 Mention : $mention", 0, 1, 'C', true);
$pdf->Ln(10);
$pdf->SetTextColor(100);
$pdf->Cell(190, 10, "🔹 Généré automatiquement par le système 🔹", 0, 1, 'C');

ob_end_clean();
$pdf->Output('D', "resultat_$matricule.pdf")
?>