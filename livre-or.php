<?php
session_start();
$host = "localhost";
$username = "root";
$dataBasePassword = "";
$database = "livreor";
$connexion = mysqli_connect($host, $username, $dataBasePassword, $database);
if (!$connexion) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

$message = 'Vos meilleurs commentaires !';

$query = "SELECT
            utilisateurs.login AS nomUtilisateur,
            commentaires.commentaire AS commentText
        FROM utilisateurs
        JOIN commentaires 
            ON commentaires.id_utilisateur = utilisateurs.id;";

// Exécution de la requête
$result = mysqli_query($connexion, $query);

if ($result) {
    // Récupération de la première ligne
    $firstRow = mysqli_fetch_assoc($result);

    // Récupération des noms de colonnes
    if ($firstRow) {
        $columns = array_keys($firstRow);
    }
} else {
    die("Erreur dans la requête : " . mysqli_error($connexion));
}
?>
<nav>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="inscription.php">Inscription</a></li>
        <li><a href="connexion.php">Connexion</a></li>
        <li><a href="profil.php">Profil</a></li>
        <li class="adminBar"><a href="admin.php">Admin</a></li>
    </ul>
</nav>
<h1>Commentaires</h1>

<table>
    <thead>
        <tr>
            <td>Nom d'utilisateur</td>
            <td>Commentaire</td>
        </tr>
    </thead>
    <tbody>
        <!-- Affiche la première ligne -->
        <tr>
            <?php foreach ($firstRow as $val): ?>
                <td><?= $val ?></td>
            <?php endforeach; ?>
        </tr>

        <!-- Affiche les lignes suivantes -->
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <?php foreach ($row as $val): ?>
                    <td><?= $val ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>