<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Résultats</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        .form-container {
            width: 100%;
            max-width: 600px;
            padding: 40px;
            background-color: #fefefe;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            font-size: 18px;
            padding: 12px;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #ffffff;
            color: #007bff;
            border: 1px solid #007bff;
        }

        label {
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>🎓 Consulter Mes Résultats</h2>
    <form action="resultat.php" method="POST">
        <div class="mb-3">
            <label for="matricule" class="form-label">Matricule :</label>
            <input type="text" name="matricule" id="matricule" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="filiere" class="form-label">Filière :</label>
            <select name="filiere" id="filiere" class="form-select" required>
                <option value="">Sélectionnez votre filière</option>
                <option value="informatique">Informatique</option>
                <option value="gestion">Gestion</option>
                <option value="comptabilité">Comptabilité</option>
                <!-- Ajoute d'autres options ici -->
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Voir Résultats</button>
    </form>
</div>

</body>
</html>