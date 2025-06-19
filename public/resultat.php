<?php
include("config.php"); // suppose que $pdo (l'objet PDO PostgreSQL) est déjà créé ici

$matricule = trim(htmlspecialchars($_POST['matricule']));
$filiere_id = intval($_POST['filiere_id']);

// Vérifier si l'étudiant existe
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
    header("Location: resultat.html?error=" . urlencode("❌ Aucun étudiant trouvé !"));
    exit();
}

$nom_etudiant = $etudiant['nom'];
$nom_filiere = $etudiant['nom_filiere'];

// Récupérer les notes de l'étudiant
$query_notes = "SELECT m.nom_matiere, n.note_devoir, n.note_examen, n.moyenne, n.valide 
                FROM notes n 
                JOIN matieres m ON n.matiere_id = m.id 
                WHERE n.etudiant_id = :matricule";
$stmt_notes = $pdo->prepare($query_notes);
$stmt_notes->execute([':matricule' => $matricule]);
$notes = $stmt_notes->fetchAll(PDO::FETCH_ASSOC);

echo "<style>
    table {
        border: 3px solid black;
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        border: 2px solid black;
        padding: 12px;
        text-align: center;
    }
    th {
        background-color: #003366;
        color: white;
    }
    tr:hover {
        background-color: #f1f1f1;
    }
</style>";

echo "<div class='container mt-5'>
        <h2 class='text-center text-primary'>📌 Résultats de <strong>$nom_etudiant</strong> ($matricule)</h2>
        <h4 class='text-center text-secondary'>Filière : <strong>$nom_filiere</strong></h4>
        <br>
        <table class='table table-bordered table-hover'>
            <thead>
                <tr>
                    <th>Matière</th>
                    <th>Devoir</th>
                    <th>Examen</th>
                    <th>Moyenne</th>
                    <th>Validé</th>
                </tr>
            </thead>
            <tbody>";

$moyenne_generale = 0;
$total_matieres = count($notes);

foreach ($notes as $row) {
    $moyenne_generale += $row['moyenne'];
    $valide = ($row['valide'] === 't' || $row['valide'] === true) 
                ? "<span class='badge bg-success'>✅ Oui</span>" 
                : "<span class='badge bg-danger'>❌ Non</span>";

    echo "<tr>
            <td>{$row['nom_matiere']}</td>
            <td>{$row['note_devoir']}</td>
            <td>{$row['note_examen']}</td>
            <td>{$row['moyenne']}</td>
            <td>$valide</td>
          </tr>";
}

echo "</tbody></table>";

echo "<div class='text-center mt-4'>
        <a href='pdf.php?matricule=$matricule&filiere_id=$filiere_id' class='btn btn-danger btn-lg'>
            📄 Télécharger en PDF
        </a>
      </div>";

echo "</div>";
echo "<div class='text-center mt-4'>
        <a href='decon.php' class='btn btn-danger'>🚪 Déconnexion</a>
      </div>";
?>