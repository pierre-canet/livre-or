<?php
session_start();
$host = "localhost";
$username = "root";
$dataBasePassword = "";
$database = "livreor";
$connexion = mysqli_connect($host, $username, $dataBasePassword, $database);
$message = 'Veuillez rester respectueux lors de l\'écriture de votre commentaire, les commentaires insultants, discrimininants et irrespecteux seront supprimés par l\'admnistration du site.';
$error = '';

// On vérifie que le champ "Votre commentaire" ne soit pas vide
if (isset($_POST['commentSubmit'])) {
    //lien et sécurisation des champs du formulaires à des variables
    $comment_text = htmlspecialchars(trim($_POST['commentText']));
    $user_id = $_SESSION['id'];
    $datetime = date('Y-m-d H:i:s');
    if (empty($_POST['commentText'])) {
        $error = "Veuillez remplir le champ commentaire";
    } else {
        // La condition est remplie donc on insère le commentaire en base de données
        $statement = $connexion->prepare("INSERT INTO commentaires (commentaire, id_utilisateur, date) VALUES ( ?, ?, ?)");
        $statement->bind_param("sss", $comment_text, $user_id, $datetime);
        $statement->execute();
        header("Location: commentaire.php?success=1");
        exit();
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

    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>

        <p style="color:green;">
            Votre commentaire a bien été posté, merci pour votre avis, nous vous souhaitons
            une bonne journée !
        </p>
    <?php endif; ?>
<?php elseif (!isset($_SESSION['login'])): ?>
    <p>Vous devez être connecté pour pouvoir poster un commentaire</p>
    <a href="connexion.php"><button>Se connecter</button></a>
<?php endif ?>