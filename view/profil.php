<?php
session_start();
$host = "localhost";
$username = "root";
$dataBasePassword = "";
$database = "livreor";
$connexion = mysqli_connect($host, $username, $dataBasePassword, $database);
$message = '';
$loginNew = '';
$passwordNew = '';
$success = '0';
//Si l'utilisateur est connecté on récupère ses données en base de données et on affiche ses informations de profil
if (isset($_SESSION['login'])) {
    $login = $_SESSION['login'];
    $query = "SELECT * FROM utilisateurs WHERE id = " . $_SESSION['id'];
    $result = mysqli_query($connexion, $query);
    $user = mysqli_fetch_assoc(mysqli_query($connexion, $query));
    $column = array_keys($user);
}

if (isset($_POST['submit'])) {
    if (!empty($_POST['loginChange'])) {
        $loginNew = htmlspecialchars(trim($_POST['loginChange']));
        $check = $connexion->prepare("SELECT id FROM utilisateurs WHERE login = ?");
        $check->bind_param("s", $loginNew);
        $check->execute();
        $check->store_result();

        //on vérifie que le login n'est pas déjà pris
        if ($check->num_rows > 0) {
            $message = "Ce login est déjà utilisé.";
        } else {
            $statement = $connexion->prepare("UPDATE utilisateurs SET login = ? WHERE id = ?");
            $statement->bind_param("si", $loginNew, $_SESSION['id']);
            $statement->execute();
            $success = '1';
        };
    };
    if (!empty($_POST['passwordChange'])) {
        if ($_POST['passwordChange'] !== $_POST['passwordConfirm']) {
            $message = 'Les mots de passe doivent être identiques';
        } else {
            $passwordNew = password_hash($_POST['passwordChange'], PASSWORD_DEFAULT);
            $statement = $connexion->prepare("UPDATE utilisateurs SET password = ? WHERE id = ?");
            $statement->bind_param("si", $passwordNew, $_SESSION['id']);
            $statement->execute();
            $success = '1';
        };
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
        Login :<input type="text" name="loginChange">
        mot de passe : <input type="password" name="passwordChange">
        mot de passe : <input type="password" name="passwordConfirm">
        <button type="submit" name="submit">Valider</button>
    </form>

<?php elseif (!isset($_SESSION['login'])) : ?>
    <p>Vous devez être connecté pour pouvoir accéder à votre profil</p>
<?php endif; ?>