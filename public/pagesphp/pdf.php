<?php
ob_start();
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/erreurs_pdf.log');

require('fpdf.php');
include("config.php");

$matricule = htmlspecialchars($_GET['matricule'] ?? '');
$filiere_id = intval($_GET['filiere_id'] ?? 0);

// Vérification étudiant
$query = "SELECT e.matricule, e.nom, f.nom_filiere
          FROM etudiants e
          JOIN filieres f ON e.filiere_id = f.id
          WHERE e.matricule = :matricule AND f.id = :filiere_id";
$stmt = $pdo->prepare($query);
$stmt->execute([':matricule' => $matricule, ':filiere_id' => $filiere_id]);
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$etudiant) {
    ob_end_clean();
    die("Erreur : Étudiant non trouvé.");
}

$nom = mb_convert_encoding($etudiant['nom'], 'ISO-8859-1', 'UTF-8');
$filiere = mb_convert_encoding($etudiant['nom_filiere'], 'ISO-8859-1', 'UTF-8');

// Récupération des notes
$sql = "SELECT m.nom_matiere, n.note_devoir, n.note_examen, n.moyenne, n.valide 
        FROM notes n 
        JOIN matieres m ON n.matiere_id = m.id 
        WHERE n.etudiant_id = :matricule";
$req = $pdo->prepare($sql);
$req->execute([':matricule' => $matricule]);
$notes = $req->fetchAll(PDO::FETCH_ASSOC);

// Génération PDF
$pdf = new FPDF();
$pdf->SetMargins(10, 10, 10); // Marges resserrées
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(0, 51, 102);
$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(190, 12, mb_convert_encoding("Résultats de $nom ($matricule)", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C', true);
$pdf->Cell(190, 12, mb_convert_encoding("Filière : $filiere", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C', true);
$pdf->Ln(12);

// En-têtes
$pdf->SetFont('Arial', 'B', 13);
$pdf->SetFillColor(0, 51, 102);
$pdf->SetTextColor(255);
$headers = ['Matière', 'Devoir', 'Examen', 'Moyenne', 'Validé'];
$widths = [50, 30, 30, 30, 30];
foreach ($headers as $i => $h) {
    $pdf->Cell($widths[$i], 14, mb_convert_encoding($h, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
}
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0);
$moyenne_generale = 0;
$total = count($notes);

foreach ($notes as $n) {
    $matiere = mb_convert_encoding($n['nom_matiere'], 'ISO-8859-1', 'UTF-8');
    $devoir = $n['note_devoir'];
    $examen = $n['note_examen'];
    $moyenne = $n['moyenne'];
    $valide = ($n['valide'] === 't' || $n['valide'] === true) ? "Oui" : "Non";

    $pdf->SetFillColor(245, 245, 245);
    $pdf->Cell(50, 14, $matiere, 1, 0, 'C', true);
    $pdf->Cell(30, 14, $devoir, 1, 0, 'C', true);
    $pdf->Cell(30, 14, $examen, 1, 0, 'C', true);
    $pdf->Cell(30, 14, $moyenne, 1, 0, 'C', true);
    $pdf->Cell(30, 14, mb_convert_encoding($valide, 'ISO-8859-1', 'UTF-8'), 1, 1, 'C', true);

    $moyenne_generale += floatval($moyenne);
}

// Résumé
$moyenne = ($total > 0) ? round($moyenne_generale / $total, 2) : 0;
$mention = "Insuffisant";
if ($moyenne >= 16) $mention = "Très Bien";
elseif ($moyenne >= 14) $mention = "Bien";
elseif ($moyenne >= 12) $mention = "Assez Bien";
elseif ($moyenne >= 10) $mention = "Passable";

$pdf->Ln(12);
$pdf->SetFont('Arial', 'B', 13);
$pdf->SetTextColor(0, 51, 102);
$pdf->Cell(190, 12, mb_convert_encoding("📊 Moyenne Générale : $moyenne", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C', true);
$pdf->Cell(190, 12, mb_convert_encoding("🏅 Mention : $mention", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C', true);

$pdf->Ln(10);
$pdf->SetTextColor(100);
$pdf->Cell(190, 10, mb_convert_encoding("🔹 Généré automatiquement par le système 🔹", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

ob_end_clean();
$pdf->Output('D', "resultat_$matricule.pdf");