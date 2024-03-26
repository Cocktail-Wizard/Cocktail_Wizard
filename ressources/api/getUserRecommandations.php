<?php
header("Content-Type: application/json");
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/fonctionAPIphp/InfoAffichageCocktail.php';
require_once __DIR__ . '/fonctionAPIphp/usernameToId.php';

$id_cocktail = [];
$cocktails = [];

// Connexion à la base de données
$conn = connexionBD();

if ($conn == null) {
    http_response_code(500);
    echo json_encode("Erreur de connexion à la base de données.");
    exit();
}
if ($type != 'tout' && $type != 'classiques' && $type != 'favoris' && $type != 'communaute') {
    http_response_code(400);
    echo json_encode("Paramètre de type invalide.");
    exit();
}

$id_user = usernameToId($username, $conn);

switch ($type) {
    case 'tout':

        if (isset($_GET['tri']) && ($_GET['tri'] == 'like' || $_GET['tri'] == 'date')) {
            $triage_s = mysqli_real_escape_string($conn, $_GET['tri']);
        } else {
            http_response_code(400);
            echo json_encode("Paramètre de triage invalide.");
            exit();
        }
        $requete_preparee = $conn->prepare("CALL GetCocktailGalerieFiltrer(?,?)");
        $requete_preparee->bind_param("is", $id_user, $triage_s);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();
        $requete_preparee->close();
        break;
    case 'classiques':
        $requete_preparee = $conn->prepare("CALL GetCocktailPossibleClassique(?)");
        $requete_preparee->bind_param("i", $id_user);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();
        $requete_preparee->close();
        break;
    case 'favoris':
        $requete_preparee = $conn->prepare("CALL getCocktailFavorieMonBar(?)");
        $requete_preparee->bind_param("i", $id_user);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();
        $requete_preparee->close();
        break;
    case 'communaute':
        $requete_preparee = $conn->prepare("CALL getCocktailCommunataireMonBar(?)");
        $requete_preparee->bind_param("i", $id_user);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();
        $requete_preparee->close();
        break;
    default:
        http_response_code(400);
        echo json_encode("Paramètre de type invalide.");
        exit();
}

if ($resultat->num_rows > 0) {
    //Ajoute les id des cocktails à la liste
    while ($row = $resultat->fetch_assoc()) {
        $id_cocktail[] = $row['id_cocktail'];
    }
} else {
    http_response_code(404);
    echo json_encode("Aucun cocktail trouvé.");
    exit();
}

foreach ($id_cocktail as $id) {
    $cocktails[] = InfoAffichageCocktail($id, $conn);
}

echo json_encode($cocktails);

$conn->close();
