<?php

$json_data = file_get_contents('php://input');

if (!empty($json_data)) {
    // Decode JSON data
    $data = json_decode($json_data, true);

    // Check if decoding was successful
    if ($data !== null) {
        // JSON data is now available as an associative array
        print_r($data);

        if ($data['type'] == "utilisateur") {
            require "get-utilisateur.php";
        }
        if ($data['type'] == "cocktail") {
            require "get-cocktail.php";
        }

    } else {
        // Error decoding JSON
        echo "Error decoding JSON data";
    }
} else {
    // No data received
    echo "No data received";
}


?>
