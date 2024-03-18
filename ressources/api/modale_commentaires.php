<?php
require("config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : 'date';

        $requete_preparee = $conn->prepare("CALL GetCommentairesCocktail(?, ?)");

        $requete_preparee->bind_param("is", $_GET["id"], $orderby);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();

        $row = $resultat->fetch_assoc();

        echo json_encode(($resultat->num_rows > 0) ? array(
            'auteur' => $row['nom'],
            'nb_likes' => $row['nb_like'],
            'img_profile' => $row['img'],
            'date_publication' => $row['date_commentaire'],
            'message' => $row['contenu']
        ) : null);
    }
}
