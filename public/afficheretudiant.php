<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Étudiants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">📚 Liste des Étudiants</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Matricule</th>
                        <th>Nom</th>
                        <th>Filière</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once 'config.php'; 

                    try {
                        $sql = "SELECT e.matricule, e.nom, f.nom_filiere 
                                FROM etudiants e
                                LEFT JOIN filieres f ON e.filiere_id = f.id";
                        $stmt = $pdo->query($sql);

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['matricule']) . "</td>
                                    <td>" . htmlspecialchars($row['nom']) . "</td>
                                    <td>" . htmlspecialchars($row['nom_filiere'] ?? 'Non renseignée') . "</td>
                                  </tr>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='3' class='text-danger'>Erreur : " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>