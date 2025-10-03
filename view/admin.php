<?php
require_once 'admin_model.php';
session_start();
$host = "localhost";
$username = "root";
$dataBasePassword = "";
$database = "livreor";
$connexion = mysqli_connect($host, $username, $dataBasePassword, $database);
$message = 'bienvenue sur l\'interface admnistrateur';




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