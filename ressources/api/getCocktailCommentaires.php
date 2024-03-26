<?php
header("Content-Type: application/json");
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/../classephp/Commentaire_Classe.php');

$conn = connexionBD();

if ($conn == null) {
    http_response_code(500);
    echo json_encode("Erreur de connexion à la base de données.");
    exit();
}

if (!isset($_GET['id_cocktail'])) {
    http_response_code(400);
    echo json_encode("Erreur: id_cocktail manquant.");
    exit();
}

$id_cocktail = $_GET['id_cocktail'];

// Liste d'objets commentaires du cocktail
$commentaires = [];

$id_cocktail_s = mysqli_real_escape_string($conn, $id_cocktail);
$id_cocktails_s = intval($id_cocktail_s);

$requete_preparee = $conn->prepare("CALL GetCommentairesCocktail(?, 'like')");
$requete_preparee->bind_param("i", $id_cocktail_s);
$requete_preparee->execute();
$resultat = $requete_preparee->get_result();

if ($resultat->num_rows > 0) {
    while ($row = $resultat->fetch_assoc()) {
        $commentaire = new Commentaire($row['id_commentaire'], $row['img'], $row['nom'], $row['date_commentaire'], $row['contenu'], $row['nb_like']);
        $commentaires[] = $commentaire;
    }
}

$requete_preparee->close();

echo json_encode($commentaires);

$conn->close();
