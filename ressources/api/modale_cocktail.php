<?php
require("config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $requete_preparee = $conn->prepare("CALL GetInfoCocktailComplet(?)");
        $requete_preparee->bind_param("i", $_GET["id"]);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();

        $row = $resultat->fetch_assoc();

        echo json_encode(($resultat->num_rows > 0) ? array(
            'nom' => $row['nom'],
            'description' => $row['desc_cocktail'],
            'preparation' => $row['preparation'],
            'nb_like' => $row['nb_like'],
            'date_publication' => $row['date_publication'],
            'type_verre' => $row['type_verre'],
            'umami' => $row['profil_saveur'],
            'auteur' => $row['auteur'],
            'illustration' => $row['img']
        ) : null);
    }
}
