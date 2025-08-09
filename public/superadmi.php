<?php
session_start();
require_once 'config.php';

$action = $_POST['action'] ?? 'etudiant';
$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM administrateurs WHERE nom = ?");
    $stmt->execute([$nom]);
    $admin = $stmt->fetch();

    if ($admin) {
        $_SESSION['verifie'] = true;
        $_SESSION['nom_admin'] = $nom;

        switch ($action) {
            case 'etudiant':
                header("Location: etudiant.html");
                break;
            case 'filiere':
                header("Location: filiere.html");
                break;
            case 'matiere':
                header("Location: matiere.html");
                break;
            case 'note':
                header("Location: note.html");
                break;
            default:
                header("Location: admi_espace.html");
        }
        exit;
    } else {
        $erreur = "Nom d'utilisateur introuvable.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vérification d'identité</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h4>🔐 Vérification d'identité</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($erreur)) echo "<div class='alert alert-danger'>$erreur</div>"; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom d'utilisateur</label>
                        <input type="text" name="nom" id="nom" class="form-control" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" name="action" value="etudiant" class="btn btn-primary">Ajouter Étudiant</button>
                        <button type="submit" name="action" value="filiere" class="btn btn-secondary">Ajouter Filière</button>
                        <button type="submit" name="action" value="matiere" class="btn btn-success">Ajouter Matière</button>
                        <button type="submit" name="action" value="note" class="btn btn-warning">Ajouter Note</button>
                    </div>
                </form>
                <a href="admi_espace.html" class="btn btn-outline-dark mt-3">⬅ Retour à l'espace admin</a>
            </div>
        </div>
    </div>
</body>
</html>