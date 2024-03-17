<?php
require("config.php");
session_start();

$saveursUmami = ["Sucré", "Aigre", "Amer", "Épicé", "Salé"];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["nombre"])) {
        for ($i = 0; $i < $_GET["nombre"]; $i++) {
            $cocktails[] = array(
                "id_cocktail" => $i,
                "nom" => "Cocktail " . $i + 1,
                "nb_likes" => rand(0, 1000),
                "date_publication" => new DateTime(),
                "umami" => $saveursUmami[$i % count($saveursUmami)]
            );
        }

        echo json_encode($cocktails);
    }
}
