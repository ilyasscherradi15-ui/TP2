<?php
session_start();
$d = $_SESSION['data'] ?? [];
$erreurs = $_SESSION['erreurs'] ?? [];
unset($_SESSION['erreurs']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire</title>
</head>
<body>

    <?php if (!empty($erreurs)): ?>
        <div style="color:red;">
            <?php foreach ($erreurs as $e): ?>
                <p><?= htmlspecialchars($e) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="recap.php" method="POST" enctype="multipart/form-data">

        <h3>Renseignements Personnels</h3>

        <input type="text" name="nom" placeholder="Nom" value="<?= htmlspecialchars($d['nom'] ?? '') ?>" required>
        <input type="text" name="prenom" placeholder="Prénom" value="<?= htmlspecialchars($d['prenom'] ?? '') ?>" required>
        <input type="number" name="age" min="0" placeholder="Âge" value="<?= htmlspecialchars($d['age'] ?? '') ?>">
        <input type="tel" name="tel" placeholder="Téléphone" value="<?= htmlspecialchars($d['tel'] ?? '') ?>">
        <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($d['email'] ?? '') ?>">
        <input type="date" name="date_naissance" value="<?= htmlspecialchars($d['date_naissance'] ?? '') ?>">

        <h3>Renseignements Académiques</h3>

        <p>Filière :</p>
        <input type="radio" name="filiere" value="2AP" <?= ($d['filiere'] ?? '') === '2AP' ? 'checked' : '' ?>> 2AP
        <input type="radio" name="filiere" value="GSTR" <?= ($d['filiere'] ?? '') === 'GSTR' ? 'checked' : '' ?>> GSTR
        <input type="radio" name="filiere" value="GI" <?= ($d['filiere'] ?? '') === 'GI' ? 'checked' : '' ?>> GI
        <input type="radio" name="filiere" value="SCM" <?= ($d['filiere'] ?? '') === 'SCM' ? 'checked' : '' ?>> SCM
        <input type="radio" name="filiere" value="GC" <?= ($d['filiere'] ?? '') === 'GC' ? 'checked' : '' ?>> GC
        <input type="radio" name="filiere" value="MS" <?= ($d['filiere'] ?? '') === 'MS' ? 'checked' : '' ?>> MS

        <p>Année :</p>
        <select name="annee">
            <option value="1" <?= ($d['annee'] ?? '') === '1' ? 'selected' : '' ?>>1ère année</option>
            <option value="2" <?= ($d['annee'] ?? '') === '2' ? 'selected' : '' ?>>2ème année</option>
            <option value="3" <?= ($d['annee'] ?? '') === '3' ? 'selected' : '' ?>>3ème année</option>
        </select>

        <p>Modules suivis :</p>
        <input type="checkbox" name="modules[]" value="Compilation" <?= in_array('Compilation', $d['modules'] ?? []) ? 'checked' : '' ?>> Compilation
        <input type="checkbox" name="modules[]" value="Reseaux Av" <?= in_array('Reseaux Av', $d['modules'] ?? []) ? 'checked' : '' ?>> Réseaux Av.
        <input type="checkbox" name="modules[]" value="Web Avance" <?= in_array('Web Avance', $d['modules'] ?? []) ? 'checked' : '' ?>> Web Avancé
        <input type="checkbox" name="modules[]" value="POO" <?= in_array('POO', $d['modules'] ?? []) ? 'checked' : '' ?>> POO
        <input type="checkbox" name="modules[]" value="BD" <?= in_array('BD', $d['modules'] ?? []) ? 'checked' : '' ?>> BD

        <p>Nombre de projets réalisés cette année :</p>
        <input type="number" name="nb_projets" min="0" value="<?= htmlspecialchars($d['nb_projets'] ?? '') ?>">

        <h3>Remarques</h3>
        <textarea name="remarques"><?= htmlspecialchars($d['remarques'] ?? '') ?></textarea>

        <h3>Fichier</h3>
        <input type="file" name="fichier">

        <br><br>
        <button type="submit">Envoyer</button>
        <button type="reset">Effacer</button>

    </form>
</body>
</html>