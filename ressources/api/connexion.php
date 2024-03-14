<?php

$con = mysqli_init();
mysqli_ssl_set($con, NULL, NULL, NULL, NULL, NULL);
mysqli_real_connect(
    $con,
    "cocktailwizbd.mysql.database.azure.com",
    "cocktail",
    "Cw-yplmv",
    "cocktailwizardbd",
    3306,
    MYSQLI_CLIENT_SSL
);

if ($con->connect_error) {
    echo "Erreur de connexion a la BD";
}

echo "Informations serveur: " . $con->get_server_info() . "</br>";

?>
