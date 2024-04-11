<?php
header("content-type: application/json");
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/fonctionAPIphp/paramJSONvalide.php");

$conn = connexionBD();

$donnee = json_decode(file_get_contents("php://input"), true);

$nomIng = paramJSONvalide($donnee, "nomIng");
$typeIng = paramJSONvalide($donnee, "typeIng");

try {
    if($typeIng == "alcool"){
        $requete_preparee = $conn->prepare("CALL ajoutAlcoolBD(?)");
        $requete_preparee->bind_param("s", $nomIng);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();
        $requete_preparee->close();
        if($resultat->num_rows > 0){
            $row = $resultat->fetch_assoc();
            echo json_encode($row['success']==1 ? "Alcool ajouté" : "Alcool déjà existant");
        }
        else{
            http_response_code(404);
            echo json_encode("Erreur lors de l'ajout de l'alcool");
        }
    }
    elseif($typeIng == "ingredient"){
        $requete_preparee = $conn->prepare("CALL ajoutIngredientBD(?)");
        $requete_preparee->bind_param("s", $nomIng);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();
        $requete_preparee->close();
        if($resultat->num_rows > 0){
            $row = $resultat->fetch_assoc();
            echo json_encode($row['success']==1 ? "Ingrédient ajouté" : "Ingrédient déjà existant");
        }
        else{
            http_response_code(404);
            echo json_encode("Erreur lors de l'ajout de l'ingrédient");
        }
    }
    else{
        http_response_code(400);
        echo json_encode("Erreur : Type d'ingrédient invalide");
        exit();
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode("Erreur lors de l'exécution de la requête : " . $e->getMessage());
}
