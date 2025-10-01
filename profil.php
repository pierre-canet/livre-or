<?php
session_start();
$host = "localhost";
$username = "root";
$dataBasePassword = "";
$database = "livreor";
$connexion = mysqli_connect($host, $username, $dataBasePassword, $database);
$message = '';
//Si l'utilisateur est connecté on récupère ses données en base de données et on affiche ses informations de profil
if (isset($_SESSION['login'])) {
    $login = $_SESSION['login'];
    $query = "SELECT * FROM utilisateurs WHERE id = " . $_SESSION['id'];
    $result = mysqli_query($connexion, $query);
    $user = mysqli_fetch_assoc(mysqli_query($connexion, $query));
    $column = array_keys($user);
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

<?php if (isset($_SESSION['login'])) : ?>
    <table>
        <thead>
            <?php foreach ($column as $col) : ?>
                <th><?= htmlspecialchars($col) ?></th>
            <?php endforeach; ?>
        </thead>
        <tbody>
            <?php foreach ($user as $val): ?>
                <td><?= htmlspecialchars($val) ?></td>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h2>Modifiez votre profil</h2>
    <form action="" method="POST">
        Login :<input type="text">
        mot de passe : <input type="password">
        <button type="submit">Valider</button>
    </form>

<?php elseif (!isset($_SESSION['login'])) : ?>
    <p>Vous devez être connecté pour pouvoir accéder à votre profil</p>
<?php endif; ?>