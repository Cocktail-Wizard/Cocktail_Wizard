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
require_once __DIR__ . '/../classephp/Utilisateur_Classe.php';
require_once __DIR__ . '/fonctionAPIphp/usernameToId.php';

$conn = connexionBD();

$userId = usernameToId($username, $conn);

try {
    $requete_preparee = $conn->prepare("CALL GetInfoUtilisateur(?)");
    $requete_preparee->bind_param('i', $userId);
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();
    $requete_preparee->close();

    if ($resultat->num_rows > 0) {
        $row = $resultat->fetch_assoc();
        $user = new Utilisateur($row['nom'], $row['courriel'], $row['img']);
    } else {
        http_response_code(204);
        echo json_encode("Aucun utilisateur trouvé.");
        exit();
    }

    echo json_encode($user);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode("Erreur : " . $e->getMessage());
    exit();
}

$conn->close();
