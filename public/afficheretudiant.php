<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Étudiants</title>
    <!-- Intégration de Bootstrap -->
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
                    include 'config.php';
                    $sql = "SELECT e.matricule, e.nom, f.nom_filiere AS filier FROM etudiants e
                    LEFT JOIN filieres f ON e.filiere_id = f.id";
                    foreach ($pdo->query($sql) as $row) {
                        echo "<tr>
                                <td>{$row['matricule']}</td>
                                <td>{$row['nom']}</td>
                                <td>{$row['nom_filiere']}</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>