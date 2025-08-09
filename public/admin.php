<?php
include 'config.php'; // $pdo est censé être défini ici

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $mot_de_passe = password_hash($_POST["mot_de_passe"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO administrateurs (nom, email, mot_de_passe) 
            VALUES (:nom, :email, :mot_de_passe)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        ':nom' => $nom,
        ':email' => $email,
        ':mot_de_passe' => $mot_de_passe
    ]);

    if ($result) {
        echo "<div class='alert alert-success'>Inscription réussie !</div>";
    } else {
        echo "<div class='alert alert-danger'>Erreur : une erreur s'est produite.</div>";
    }
}
?>