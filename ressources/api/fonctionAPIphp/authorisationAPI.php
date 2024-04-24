<?php

// Fonction qui vérifie si l'utilisateur a accès à la ressource demandée
/**
 * Fonction userAccesResssource
 *
 * Cette fonction vérifie si l'utilisateur à accès à la ressource demandée.
 * Si un token est présent dans le header, il est comparé avec le hash du nom d'utilisateur.
 * Si un token n'est pas présent, la fonction vérifie si l'utilisateur possède une session active et
 * si le nom d'utilisateur correspond à celui de la requête.
 *
 * @param string $usernameRequete
 *
 *
 */
function userAccesResssource($usernameRequete)
{

    if (isset($_SERVER['HTTP_AUTH'])) {
        include(__DIR__ . '/../../../../configDonne.php');
        $token = $_SERVER['HTTP_AUTH'];
        $usernameRequeteHash = hash_hmac('sha256', $usernameRequete, $cle);
        if (hash_equals($token, $usernameRequeteHash)) {
            return true;
        } else {
            http_response_code(403);
            echo json_encode(array("message" => "Vous n'avez pas accès à cette ressource."));
            exit();
        }
    } else {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            if ($username == $usernameRequete) {
                return true;
            } else {
                http_response_code(403);
                echo json_encode(array("message" => "Vous n'avez pas accès à cette ressource."));
                exit();
            }
        } else {
            http_response_code(401);
            echo json_encode(array("message" => "Vous n'êtes pas connecté."));
            exit();
        }
    }
}
