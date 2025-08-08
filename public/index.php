<?php include 'config.php'; ?>
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
        .banner {
            width: 100%;
            height: 250px;
            background-image: url('https://www.boldbi.com/resources/blog/educational-insights-analyzing-student-performance-with-bi-dashboards/images/student-performance-dashboard.png');
            background-size: cover;
            background-position: center;
            border-bottom: 5px solid #ffd700;
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
            background: #ffd700;
            color: #002b5e;
        }
        a.email-link {
            color: #ffd700;
            text-decoration: underline;
        }
        .testimonial {
            font-style: italic;
            margin-top: 30px;
            color: #e0e0e0;
        }
        .icon {
            width: 60px;
            margin-bottom: 20px;
        }
        .custom-image {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>

    <div class="banner"></div>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="floating-box text-center">
            <img src="image/imgs.jpeg" alt="Des étudiants souriants célèbrent leur réussite dans une atmosphère positive et conviviale." class="custom-image">

            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png" alt="Graduation Icon" class="icon">
            <h1>🎓 Consultation des Résultats</h1>
            <p>Bienvenue sur la plateforme officielle de consultation des résultats académiques. Accédez rapidement et en toute sécurité aux performances des étudiants.</p>
            
            <p class="mt-3">
                📬 Pour toute question, contactez-nous par 
                <a href="mailto:atandjijero@gmail.com" class="email-link">email</a>
            </p>

            <div class="mt-4">
                <a href="resultat.html" class="btn btn-custom">📖 Consulter les Résultats</a>
                <a href="login.html" class="btn btn-custom">🔑 Espace Admin</a>
            </div>

            <div class="testimonial">
                « Le savoir est la clé du succès. Consultez vos résultats et préparez votre avenir dès aujourd'hui. »
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>