<?php
    require("../ressources/api/connexion.php");
    // Accumulateur d'erreurs
    $erreurs = array();

    if($_SERVER["REQUEST_METHOD"]=="POST")
    {

        // Valider l'identifiant
        if(empty($_POST['nom'])) {
            $erreurs[] = "L'identifiant est invalide!<br>";
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
            $date_nais = mysqli_real_escape_string($conn, trim($_POST['naissance']));
            if($conn == null)
            {
                die("Erreur");
            }
            $requete_preparee = $conn->prepare("SELECT * FROM utilisateur WHERE nom = ?");
            $requete_preparee->bind_param("s", $identifiant);
            $requete_preparee->execute();
            $resultat = $requete_preparee->get_result();
            $requete_preparee->close();
            if ($resultat->$nb_ranger > 0) {
                $erreurs[] = "Le nom d'utilisateur est déjà utilisé!";
                $conn->close();
            }

            else{
                $requete_preparee = $conn->prepare("INSERT INTO utilisateur (nom,courriel,mdp,date_nais) VALUES (?,?,?,?)");
                $requete_preparee->bind_param("ss",$identifiant,$mdp_encrypter);
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
            <img src="../images/LogoCW.png" alt="Logo Cocktail Wizard">
        </div>
        <div id="messErreur"><p>test</p>
            <?php if(count($erreurs)>0) { ?>
                <?php foreach ($erreurs as $erreur) { ?>
                    <p style="color:red"><?php echo $erreur; ?></p><br>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</body>
</html>
