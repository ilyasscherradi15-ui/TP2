<?php
session_start();

$erreurs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['action'])) {

    $email = trim($_POST['email'] ?? '');
    $num_telephone = trim($_POST['tel'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "Adresse email invalide.";
    }

    if (!preg_match('/^0[567][0-9]{8}$/', $num_telephone)) {
        $erreurs[] = "Numéro de téléphone invalide (format attendu : 06XXXXXXXX).";
    }

    if (!empty($erreurs)) {
        $_SESSION['data'] = $_POST;
        $_SESSION['erreurs'] = $erreurs;
        header('Location: formulaire.php');
        exit;
    }

    // Données valides
    $_SESSION['data'] = $_POST;

    if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] === UPLOAD_ERR_OK) {
        $nomFichier = basename($_FILES['fichier']['name']);
        move_uploaded_file($_FILES['fichier']['tmp_name'], $nomFichier);
        $_SESSION['data']['fichier_nom'] = $nomFichier;
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] === 'modifier') {
        header('Location: formulaire.php');
        exit;
    }

    if ($_POST['action'] === 'valider') {
        $d = $_SESSION['data'] ?? [];
        $modules = implode(', ', $d['modules'] ?? []);
        $contenu = "Nom: {$d['nom']}\nPrenom: {$d['prenom']}\nAge: {$d['age']}\nTel: {$d['tel']}\nEmail: {$d['email']}\nDate de naissance: {$d['date_naissance']}\nFiliere: {$d['filiere']}\nAnnee: {$d['annee']}\nModules: $modules\nNb projets: {$d['nb_projets']}\nRemarques: {$d['remarques']}\n";
        file_put_contents('fiche_' . $d['nom'] . '.txt', $contenu);
    }
}

$d = $_SESSION['data'] ?? [];
$nom = $d['nom'] ?? '';
$prenom = $d['prenom'] ?? '';
$age = $d['age'] ?? '';
$num_telephone = $d['tel'] ?? '';
$email = $d['email'] ?? '';
$date_naissance = $d['date_naissance'] ?? '';
$filiere = $d['filiere'] ?? '';
$annee = $d['annee'] ?? '';
$modules = implode(', ', $d['modules'] ?? []);
$nb_projets = $d['nb_projets'] ?? '';
$remarques = $d['remarques'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Récapitulatif</title>
</head>
<body>
    <h2>Récapitulatif</h2>

    <p><strong>Nom :</strong> <?= htmlspecialchars($nom) ?></p>
    <p><strong>Prénom :</strong> <?= htmlspecialchars($prenom) ?></p>
    <p><strong>Âge :</strong> <?= htmlspecialchars($age) ?></p>
    <p><strong>Téléphone :</strong> <?= htmlspecialchars($num_telephone) ?></p>
    <p><strong>Email :</strong> <?= htmlspecialchars($email) ?></p>
    <p><strong>Date de naissance :</strong> <?= htmlspecialchars($date_naissance) ?></p>
    <p><strong>Filière :</strong> <?= htmlspecialchars($filiere) ?></p>
    <p><strong>Année :</strong> <?= htmlspecialchars($annee) ?></p>
    <p><strong>Modules :</strong> <?= htmlspecialchars($modules) ?></p>
    <p><strong>Nombre de projets :</strong> <?= htmlspecialchars($nb_projets) ?></p>
    <p><strong>Remarques :</strong> <?= htmlspecialchars($remarques) ?></p>

    <form method="POST">
        <button type="submit" name="action" value="valider">VALIDER</button>
        <button type="submit" name="action" value="modifier">MODIFIER</button>
    </form>
</body>
</html>