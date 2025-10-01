<?php
session_start();
$host = "localhost";
$username = "root";
$dataBasePassword = "";
$database = "livreor";
$connexion = mysqli_connect($host, $username, $dataBasePassword, $database);
$message = 'Veuillez rester respectueux lors de l\'écriture de votre commentaire, les commentaires insultants, discrimininants et irrespecteux seront supprimés par l\'admnistration du site.';
$error = '';
if (isset($_POST['commentSubmit'])) {
    if (empty($_POST['commentText'])) {
        $error = "Veuillez remplir le champ commentaire";
    } else {
    };
};
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
<?php if (isset($_SESSION['login'])): ?>
    <?php echo $message ?>
    <form action="" method="POST">
        Votre commentaire :<input type="text" name="commentText" id="" required>
        <button type="submit" name="commentSubmit">Poster votre commentaire</button>
    </form>
<?php elseif (!isset($_SESSION['login'])): ?>
    <p>Vous devez être connecté pour pouvoir poster un commentaire</p>
    <a href="connexion.php"><button>Se connecter</button></a>
<?php endif ?>