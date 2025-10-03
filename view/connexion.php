<?php
session_start();
$host = "localhost";
$username = "root";
$dataBasePassword = "";
$database = "livreor";
$connexion = mysqli_connect($host, $username, $dataBasePassword, $database);
$message = '';
// logique de connexion
if (isset($_POST['loginSubmit'])) {

    //on vérifie que les champs ne soient pas vides lors de la soumission du formulaire
    if (
        !empty($_POST['login'])
        && !empty($_POST['password'])
    ) {

        //champs du formulaire
        $login = htmlspecialchars(trim($_POST['login']));
        $password = trim($_POST['password']);

        //initialisation de la requête
        $check = $connexion->prepare("SELECT * FROM utilisateurs WHERE login = ?");
        $check->bind_param("s", $login);
        $check->execute();

        // 3. Résultat
        $result = $check->get_result();
        $user = $result->fetch_assoc();

        //Vérification
        if ($user && password_verify($password, $user['password'])) {

            /*Si les identifiants sont bon on initialise une session et on redirige
vers la page de profil*/
            $_SESSION['id'] = $user['id'];
            $_SESSION['login'] = $user['login'];



            //On vérifie si l'utilisateur connecté est un admin
            if (isset($user['admin']) && $user['admin'] == 1) {
                header("Location: admin.php");
                exit();
            } else {
                header("Location: profil.php");
                exit();
            }
        } else {
            $message = "Login ou mot de passe incorrect.";
        }
    } else {
        $message = "un des champs est vide, veuillez les compléter pour envoyer
le formulaire";
    }
};

/*en appuyant sur le bouton deconnexion on supprime la session et on est redirigé
    vers l'accueil*/
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
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
<?php if (!isset($_SESSION['login'])) : ?>

    <!-- Formulaire connexion -->
    <form action="" method="POST">
        <input type="hidden" name="form_type" value="login">
        Login : <input type="text" name="login" required>
        Mot de passe : <input type="password" name="password" required>
        <button type="submit" name="loginSubmit">Connexion</button>
    </form>
    <a href="inscription.php"><button>Pas encore inscrit ?</button></a>

<?php elseif (isset($_SESSION['login'])): ?>

    <!-- UTILISATEUR CONNECTÉ -->
    <p>Bonjour <?php echo htmlspecialchars($_SESSION['login']); ?> !</p>
    <form method="POST">
        <button type="submit" name="logout">Déconnexion</button>
    </form>



<?php endif; ?>