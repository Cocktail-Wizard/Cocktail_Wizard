<?php

// Fonction qui vérifie si l'utilisateur a accès à la ressource demandée
/**
 * Fonction userAccesResssource
 *
 * Cette fonction vérifie si l'utilisateur à accès à la ressource demandée.
 *
 * @param string $usernameRequete
 *
 *
 */
function userAccesResssource($usernameRequete)
{
    if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        include(__DIR__ . '/../../../../configDonne.php');
        $token = $_SERVER['HTTP_AUTHORIZATION'];
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
