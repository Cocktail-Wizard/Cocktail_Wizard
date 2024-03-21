<?php
/*
* Fonction qui retourne l'id d'un utilisateur à partir de son nom d'utilisateur
*
*/

function usernameToId($username, $conn){
    $username_s = mysqli_real_escape_string($conn, $username);

    //Convertion du username en id
    $requete_preparee = $conn->prepare("CALL GetIdUser(?)");
    $requete_preparee->bind_param("s", $username_s);
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();
    $requete_preparee->close();

    if($resultat->num_rows == 1){
        $row = $resultat->fetch_assoc();
        $id_user = $row['id_user'];
    }
    else{
        http_response_code(404);
        echo json_encode("Aucun utilisateur trouvé.");
        exit();
    }
    return $id_user;
}
?>
