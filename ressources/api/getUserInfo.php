<?php

/**
 * Script getUserInfo
 *
 * Script de l'API qui permet de récupérer les informations d'un utilisateur. Pour la page
 * de profil.
 *
 * Type de requête : GET
 *
 * URL : /api/users/$username
 *
 * @param string $username Le nom d'utilisateur de l'utilisateur.
 *
 * @return JSON Un json contenant les informations de l'utilisateur.
 *
 * @version 1.0
 *
 * @author Yani Amellal
 */

header("Content-Type: application/json");
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/classephp/Utilisateur_Classe.php';
require_once __DIR__ . '/fonctionAPIphp/usernameToId.php';

$conn = connexionBD();

$username = mysqli_real_escape_string($conn, $_POST['username']);
$userId = usernameToId($username, $conn);

$requete_preparee = $conn->prepare("CALL GetInfoUtilisateur(?)");
$requete_preparee->bind_param('i', $userId);
$requete_preparee->execute();
$resultat = $requete_preparee->get_result();
$requete_preparee->close();

if ($resultat->num_rows == 1) {
    $row = $resultat->fetch_assoc();
    $user = new Utilisateur($row['nom'], $row['courriel'], $row['img']);
} else {
    http_response_code(404);
    echo json_encode("Erreur");
    exit();
}

echo json_encode($user);

$conn->close();
