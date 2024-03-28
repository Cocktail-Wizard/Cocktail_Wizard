<?php

/**
 * Fonction paramJSONvalide
 *
 * Cette fonction permet de vérifier si les paramètres JSON nécessaires
 * sont présents dans la requête.
 *
 * @param String $parametre Le paramètre à vérifier
 * @param String $nomParametre Le nom du paramètre à vérifier
 *
 * @version 1.0
 *
 * @author Yani Amellal
 */

function paramJSONvalide($parametre, $nomParametre)
{
    if (empty($parametre)) {
        http_response_code(400);
        echo json_encode("Le paramètre " . $nomParametre . " est requis.");
        exit();
    }
}
