<?php

if (isset($data['nom_utilisateur'])) {
    echo "Le nom d'utilisateur est : " . $data['nom_utilisateur'];
} else {
    echo "Il n'y a pas eu de nom d'utilisateur transfere.";
}

?>
