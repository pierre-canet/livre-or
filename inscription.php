<?php
session_start();
$host = "localhost";
$username = "root";
$dataBasePassword = "";
$database = "livreor";
$connexion = mysqli_connect($host, $username, $dataBasePassword, $database);
$message = '';

/**
 * On vérifie si la connexion est bien établie, si ça n'est pas le cas on retourne 
 * l'erreur, sinon on enclenche la connexion à la base de donées
 */
if (!$connexion) {
    die('Erreur de connexion' . mysqli_connect_error());
} else {
    echo 'Connexion établie';
};

//vérifie si on a appuyé sur le bouton "déjà inscrit ?"    
if (isset($_POST['goToLogin'])) {
}

//vérifie si on a appuyé sur le bouton "Pas encore de compte ?"    
if (isset($_POST['goToRegister'])) {
    $formToShow = 'register';
}




// logique d'inscription
if (isset($_POST['register'])) {

    //on vérifie si les champs ne sont pas vide à la soumission du formulaire
    if (
        !empty($_POST['login'])
        && !empty($_POST['password'])
        && !empty($_POST['passwordConfirm'])
    ) {

        //lien et sécurisation des champs du formulaires à des variables
        $login = htmlspecialchars(trim($_POST['login']));

        //on vérifie que les deux mots de passe soient identiques
        if ($_POST['password'] !== $_POST['passwordConfirm']) {
            $message = "Les mots de passe doivent être identiques";
        } else {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $check = $connexion->prepare("SELECT id FROM utilisateurs WHERE login = ?");
            $check->bind_param("s", $login);
            $check->execute();
            $check->store_result();

            //on vérifie que le login n'est pas déjà pris
            if ($check->num_rows > 0) {
                $message = "Ce login est déjà utilisé.";
            }

            //les conditions sont vérifiées donc on ajoute un nouvel utilisateur
            else {
                $statement = $connexion->prepare("INSERT INTO utilisateurs (login, password) VALUES ( ?, ?)");
                $statement->bind_param("ss", $login, $password);
                $statement->execute();
                header("Location: inscription.php?success=1");
                exit();
            }
        }
    } else {
        $message = "un des champs est vide, veuillez les compléter pour envoyer 
            le formulaire";
    }
}



/*en appuyant sur le bouton deconnexion on supprime la session et on est redirigé
    vers l'accueil*/
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>

<body>

    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="inscription.php">Inscription</a></li>
            <li><a href="connexion.php">Connexion</a></li>
            <li><a href="profil.php">Profil</a></li>
            <li class="adminBar"><a href="admin.php">Admin</a></li>
        </ul>
    </nav>

    <?php if (!isset($_SESSION['login'])): ?>

        <h1>Bienvenue</h1>
        <!-- Formulaire inscription -->
        <form method="POST">
            <input type="hidden" name="form_type" value="register">
            Login : <input type="text" name="login" required>
            Mot de passe : <input type="password" name="password" required>
            Confirmation de mot de passe : <input type="password" name="passwordConfirm" required>
            <button type="submit" name="register">Inscription</button>
        </form>
        <a href="connexion.php"><button>Déjà inscrit ?</button></a>


        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>

            <p style="color:green;">Inscription réussie ! Vous pouvez maintenant vous
                connecter.
            </p>
        <?php endif; ?>



    <?php elseif (isset($_SESSION['login'])): ?>

        <!-- UTILISATEUR CONNECTÉ -->
        <p>Bonjour <?php echo htmlspecialchars($_SESSION['login']); ?> !</p>
        <form method="POST">
            <button type="submit" name="logout">Déconnexion</button>
        </form>



    <?php endif; ?>

    <?php if (!empty($message)): ?>

        <p style="color:red;"><?php echo $message; ?></p>

    <?php endif; ?>
</body>

</html>