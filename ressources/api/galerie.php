<?php
require("config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["nombre"])) {
        $requete_preparee = $conn->prepare("SELECT id_cocktail, nom, nb_like, date_publication, profil_saveur FROM Cocktail LIMIT ?");
        $requete_preparee->bind_param("i", $_GET["nombre"]); // Utiliser "i" pour un paramètre entier
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();

        $cocktails = array(); // Initialiser le tableau des cocktails

        if ($resultat->num_rows > 0) {
            // Parcourir les résultats de la requête et construire un tableau associatif pour chaque cocktail
            while ($row = $resultat->fetch_assoc()) {
                $profil_saveur = intval($row["profil_saveur"]);
                $cocktail = array(
                    "id_cocktail" => $row["id_cocktail"],
                    "nom" => $row["nom"],
                    "nb_likes" => $row["nb_like"],
                    "date_publication" => $row["date_publication"],
                    "umami" => $row["profil_saveur"]
                );
                $cocktails[] = $cocktail; // Ajouter le cocktail au tableau des cocktails
            }
        }

        echo json_encode($cocktails); // Encoder le tableau des cocktails en JSON et l'envoyer comme réponse
    }
}
