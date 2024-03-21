<?php
/*
* Fonction qui retourne la liste des ingrédients d'un utilisateur
* pour mon bar.
*/
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/fonctionAPIphp/usernameToId.php';

// Connexion à la base de données
$conn = connexionBD();

if($conn == null){
    http_response_code(500);
    echo json_encode("Erreur de connexion à la base de données.");
    exit();
}

//Liste des noms d'ingrédients(Alcool et Ingredient)
$ingredients = [];

// Transforme le nom d'utilisateur en id
$id_user = usernameToId($username, $conn);

//Demande les noms d'ingrédients que l'utilisateur possède
$requete_preparee = $conn->prepare("CALL GetMesIngredients(?)");
$requete_preparee->bind_param("i", $id_user);
$requete_preparee->execute();
$resultat = $requete_preparee->get_result();
$requete_preparee->close();

if($resultat->num_rows > 0){
    while($row = $resultat->fetch_assoc()){
        $ingredients[] = $row['nom'];
    }

    echo json_encode($ingredients);
}
else{
    echo json_encode("Aucun");
}

$conn->close();

?>
