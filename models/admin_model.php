<?php

function get_all_comment($query, $connexion)
{
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
    } else {
        die("Erreur dans la requête : " . mysqli_error($connexion));
    }
}
