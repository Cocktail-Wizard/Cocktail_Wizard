<?php
require ("config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset ($_GET["nombre"])) {
        for ($i = 0; $i < $_GET["nombre"]; $i++) {
            $cocktails[] = [
                "id_cocktail" => $i,
                "nom" => $names[$i],
                "description" => $descriptions[$i % count($descriptions)],
                "preparation" => $preparations[$i % count($preparations)],
                "nb_likes" => rand(0, 1000),
                "date_publication" => new DateTime(),
                "verre_service" => "Verre is good",
                "classique" => true,
                "umami" => $saveursUmami[$i % count($saveursUmami)]
            ];
        }

        echo json_encode($cocktails);
    }
}
