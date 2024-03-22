<?php
header("Content-Type: application/json");
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/fonctionAPIphp/InfoAffichageCocktail.php';
require_once __DIR__ . '/fonctionAPIphp/usernameToId.php';

// Connexion à la base de données
$conn = connexionBD();

if($conn == null){
    http_response_code(500);
    echo json_encode("Erreur de connexion à la base de données.");
    exit();
}

//Liste d'objets Cocktail
$cocktails = [];
//Liste d'id de cocktails
$id_cocktail = [];

// Transforme le nom d'utilisateur en id
$id_user = usernameToId($username, $conn);

//Demande les cocktails fait par l'utilisateur
$requete_preparee = $conn->prepare("CALL GetMesCocktails(?)");
$requete_preparee->bind_param("i", $id_user);
$requete_preparee->execute();
$resultat = $requete_preparee->get_result();

$requete_preparee->close();

if($resultat->num_rows > 0){
    //Ajoute les id des cocktails à la liste
    while($row = $resultat->fetch_assoc()){
        $id_cocktail[] = $row['id_cocktail'];
    }
}
else{
    http_response_code(404);
    echo json_encode("Aucun cocktail trouvé.");
    exit();
}

foreach($id_cocktail as $id) {
    $cocktails[] = InfoAffichageCocktail($id, $conn);
}

echo json_encode($cocktails);

$conn->close();

?>
