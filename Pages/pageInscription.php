<?php
    require("../ressources/api/connexion.php");
    // Accumulateur d'erreurs
    $erreurs = array();

    if($_SERVER["REQUEST_METHOD"]=="POST")
    {

        // Valider le nom d'utilisateur
        if(empty($_POST['nom'])) {
            $erreurs[] = "Le nom d'utilisateur est invalide!<br>";
        }

        // Valider le mot de passe
        if(empty($_POST['mdp'])) {
            $erreurs[] = "Le mot de passe est invalide!<br>";
        }

        //Verifier si le mot de passe est egale a la validation du mot de passe
        if($_POST['mdp']!=$_POST['confmdp']) {
            $erreurs[] = "Les mots de passe ne sont pas identiques!<br>";
        }

        // Valider la date de naissance
        if(empty($_POST['naissance'])) {
            $erreurs[] = "La date de naissance est invalide!<br>";
        }

        // Afficher le message si le formulaire est valide
        if (count($erreurs) == 0) {
            $conn = connexion("cocktailwizbd.mysql.database.azure.com","cocktail","Cw-yplmv");

            $nom = mysqli_real_escape_string($conn, trim($_POST['nom']));
            $courriel = mysqli_real_escape_string($conn, trim($_POST['courriel']));
            $mdp = mysqli_real_escape_string($conn, trim($_POST['mdp']));
            $mdp_encrypter = password_hash($mdp, PASSWORD_DEFAULT);
            $date_nais = date('Y-m-d', strtotime(trim($_POST['naissance'])));
            if($conn == null)
            {
                die("Erreur");
            }
            $requete_preparee = $conn->prepare("SELECT * FROM utilisateur WHERE nom = ?");
            $requete_preparee->bind_param("s", $nom);
            $requete_preparee->execute();
            $resultat = $requete_preparee->get_result();
            $requete_preparee->close();
            if ($resultat->num_rows > 0) {
                $erreurs[] = "Le nom d'utilisateur est déjà utilisé!";
                $conn->close();
            }

            else{
                $requete_preparee = $conn->prepare("INSERT INTO utilisateur (nom,courriel,mdp,date_nais) VALUES (?,?,?,?)");
                $requete_preparee->bind_param("ssss",$nom,$courriel,$mdp_encrypter,$date_nais);
                if($requete_preparee->execute())
                {   //  Test ajout d'utilisateur
                    echo "Nouvel utilisateur ajouté";
                }

                $requete_preparee->close();
            }
        }
    }

?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>

    <style>
            html{
                background-color : #232946;
            }
            #conteneur-inscription{
                display: flex;
                justify-content: center;
                align-items: center
            }
            #inscription{
                display: grid;
                grid-template-columns: 1fr 1fr;
                grid-template-rows: 0.2fr 1.4fr 1.4fr;
                width: 1100px;
                height: 650px;
                background-color: #B8C1EC;
                border-radius: 50px;
            }
            #inscription > h1{
                grid-area: 1 / 1 / 2/ 3;
                font-family: 'merriweather', 'serif';
                text-align: center;
            }
            #form-inscription{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            grid-area: 2 / 1 / 4 / 2;
            }
            #form-inscription > input{
            margin-top: 0.625rem;
            margin-bottom: 0.625rem;
            padding: 0.625rem;
            border: none;
            border-radius: 1.875rem;
            width: 18.75rem;
            }
            #form-inscription > button{
                margin-top: 0.625rem;
                padding: 0.9375rem;
                font-size: 1.25rem;
                background-color: #EEBBC3;
                color: black;
                border: none;
                border-radius: 1.875rem;
                width: 13.75rem;
            }
            #image-inscription{
                display: flex;
                justify-content: center;
                align-items: center;
            }
            #image-inscription > img{
            border-radius: 50px;
            width: 36.25rem;
            height: 36.25rem;
            margin-top: 5%;
            }
            #messErreur{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            }

    </style>


</head>
<body id="conteneur-inscription">
    <div id="inscription">
        <h1>DEVENIR MEMBRE</h1>
        <form id="form-inscription" action="post">
            <label for="nom">Nom d'utilisateur</label>
            <input type="text" name="nom" placeholder="Entrer votre nom d'utilisateur" required>
            <label for="courriel">Courriel</label>
            <input type="email" name="courriel" placeholder="exemple@cocktailwizard.com" required>
            <label for="mdp">Mot de Passe</label>
            <input type="password" name="mdp" placeholder="Entrer votre mot de passe" required>
            <label for="confmdp">Confirmation Mot de Passe</label>
            <input type="password" name="confmdp" placeholder="Confirmer votre mot de passe" required>
            <label for="naissance">Date de naissance</label>
            <input type="date" name="naissance" required>
            <button type="submit">S'inscrire</button>
        </form>
        <div id="img-inscription">
            <img src="../images/LogoCW.png"  alt="Logo Cocktail Wizard">
        </div>
        <div id="messErreur">
            <?php if(count($erreurs)>0) { ?>
                <?php foreach ($erreurs as $erreur) { ?>
                    <p style="color:red"><?php echo $erreur; ?></p><br>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</body>
</html>
