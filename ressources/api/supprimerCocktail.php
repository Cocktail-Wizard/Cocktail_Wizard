<?php

header("content-type: application/json");
require_once (__DIR__."/config.php");
require_once (__DIR__."/fonctionAPIphp/paramJSONvalide.php");

$conn = connexionBD();

$donnees = json_decode(file_get_contents('php://input'), true);
$id_cocktail = paramJSONvalide($donnees, 'id_cocktail');

try {
    $requete_preparee = $conn->prepare("CALL SupprimerCocktail(?)");
    $requete_preparee->bind_param("i", $id_cocktail);
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();
    $requete_preparee->close();

    if($resultat->num_rows > 0) {
        $row = $resultat->fetch_assoc();
        echo json_encode($row["success"]);
    } else {
        http_response_code(400);
        echo json_encode("Erreur lors de la suppression de cocktail");
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode("Erreur : " . $e->getMessage());
    exit();
}
