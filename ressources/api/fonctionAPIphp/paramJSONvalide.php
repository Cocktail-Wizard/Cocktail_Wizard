<?php

/**
 * Fonction paramJSONvalide
 *
 * Cette fonction permet de vérifier si les paramètres JSON nécessaires
 * sont présents dans la requête.
 *
 * @param string $JSON Le tableau JSON contenant les paramètres de la requête
 * @param string $nomParametre Le nom du paramètre à vérifier
 *
 *
 * @return string Le paramètre
 *
 * @version 1.0
 *
 * @author Yani Amellal
 */

function paramJSONvalide($JSON, $nomParametre)
{
    if (empty($JSON[$nomParametre])) {
        http_response_code(400);
        echo json_encode("Le paramètre " . $nomParametre . " est requis.");
        exit();
    } else {
        return trim($JSON[$nomParametre]);
    }
}
