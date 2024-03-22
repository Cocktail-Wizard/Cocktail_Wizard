<?php
header('Content-Type: application/json');
require_once __DIR__ . '/config.php';

// Connexion à la base de données
$conn = connexionBD();

if($conn == null){
    http_response_code(500);
    echo json_encode("Erreur de connexion à la base de données.");
    exit();
}

//Liste des noms d'ingrédients(Alcool et Ingredient)
$ingredients = [];

//Demande les noms d'ingrédients
$requete_preparee = $conn->prepare("CALL GetListeIngredients()");
$requete_preparee->execute();
$resultat = $requete_preparee->get_result();
$requete_preparee->close();

if($resultat->num_rows > 0){
    while($row = $resultat->fetch_assoc()){
        $ingredients[] = $row['nom'];
    }
}
else{
    http_response_code(404);
    echo json_encode("Aucun ingrédient trouvé.");
    exit();
}

echo json_encode($ingredients);

$conn->close();
?>
