<?php
include 'config.php';
include "pagesphp/tonfichier.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consultation des Résultats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #002b5e, #005b96);
            color: white;
            font-family: 'Poppins', sans-serif;
        }
        .floating-box {
            background: rgba(255, 255, 255, 0.2);
            padding: 50px;
            border-radius: 15px;
            backdrop-filter: blur(15px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease-in-out;
        }
        .floating-box:hover {
            transform: translateY(-10px);
        }
        .btn-custom {
            background: white;
            color: #002b5e;
            border: none;
            padding: 14px 30px;
            font-size: 20px;
            margin: 15px;
            border-radius: 8px;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background: #005b96;
            color: white;
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="floating-box text-center">
            <h1>🎓 Consultation des Résultats</h1>
            <p>Bienvenue sur la plateforme officielle de consultation des résultats académiques. Accédez rapidement et en toute sécurité aux performances des étudiants.</p>
            <div class="mt-4">
                <a href="resultat.html" class="btn btn-custom">📖 Consulter les Résultats</a>
                <a href="login.html" class="btn btn-custom">🔑 Espace Admin</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>