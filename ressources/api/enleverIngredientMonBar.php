<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/fonctionAPIphp/usernameToId.php';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405); // Méthode non autorisée
    echo json_encode("Seules les requêtes de type DELETE sont autorisées.");
    exit();
}

//s'assurer que on delete le bon ingredient du bon utilisateur
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['nomIngredient']) || !isset($data['typeIngredient']) || !isset($data['username'])) {
    http_response_code(400);
    exit("Paramètres manquants.");
}

$conn = connexionBD();

if ($conn == null) {
    http_response_code(500);
    echo json_encode("Erreur de connexion à la base de données.");
    exit();
}

$nomIngredient = mysqli_real_escape_string($conn, $data['nomIngredient']);
$typeIngredient = mysqli_real_escape_string($conn, $data['typeIngredient']);
$username = mysqli_real_escape_string($conn, $data['username']);
$userId = usernameToId($username, $conn);

$requete_preparee = $conn->prepare("CALL RetraitIngredient(?,?,?)");
$requete_preparee->bind_param('iss', $userId, $nomIngredient, $typeIngredient);
$requete_preparee->execute();
$resultat = $requete_preparee->get_result();
$requete_preparee->close();

if ($resultat->num_rows > 0) {
    $ingredients = array();

    while ($row = $resultat->fetch_assoc()) {
        $ingredients[] = $row['nom'];
    }

    echo json_encode($ingredients);
}

$conn->close();
