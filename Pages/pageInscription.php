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

        // Valider le courriel
        if(empty($_POST['courriel']) || !str_contains($_POST["courriel"],"@") || !str_contains($_POST["courriel"],".")) {
            $erreurs[] = "Le courriel est invalide!<br>";
        }

        // Verifier si le courriel est deja utilise
        $conn = connexion("cocktailwizbd.mysql.database.azure.com","cocktail","Cw-yplmv");
        $courriel = mysqli_real_escape_string($conn, trim($_POST['courriel']));
        if($conn == null)
        {
            die("Erreur");
        }
        $requete_preparee = $conn->prepare("SELECT * FROM utilisateur WHERE courriel = ?");
        $requete_preparee->bind_param("s", $courriel);
        $requete_preparee->execute();
        $resultat = $requete_preparee->get_result();
        $requete_preparee->close();
        if ($resultat->num_rows > 0) {
            $erreurs[] = "Le courriel est déjà utilisé!";
            $conn->close();
        }

        // Valider le mot de passe
        if(empty($_POST['mdp'])) {
            $erreurs[] = "Le mot de passe est invalide!<br>";
        }
        else{
            $mdp = $_POST['mdp'];
            // Valider la date de naissance
            if(empty($_POST['naissance'])) {
                $erreurs[] = "La date de naissance est invalide!<br>";
            }
            // regex nombre charactere
            if (strlen($mdp) < 8) {
                $erreurs[] = "Le mot de passe doit contenir au moins 8 caractères!<br>";
            }
            // regex pour lettre min/max
            if(!preg_match("/[a-z]/i", $mdp)) {
                $erreurs[] = "Le mot de passe doit contenir au moins une minuscule!<br>";
            }
            // regex pour num
            if(!preg_match("/[0-9]/", $mdp)) {
                $erreurs[] = "Le mot de passe doit contenir au moins un chiffre!<br>";
            }
            // \W regex pour les caracteres speciaux
            if(!preg_match("/\W/", $mdp)) {
                $erreurs[] = "Le mot de passe doit contenir au moins un symbole!<br>";
            }
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

            // Inserer les donnees dans la base de donnee
            else{
                $requete_preparee = $conn->prepare("INSERT INTO utilisateur (nom,courriel,mdp,date_nais) VALUES (?,?,?,?)");
                $requete_preparee->bind_param("ssss",$nom,$courriel,$mdp_encrypter,$date_nais);
                if($requete_preparee->execute())
                {
                    $requete_preparee->close();
                    $conn->close();
                    header("Location: pageConnexion.php");
                    exit();
                }
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
    <!-- Mettre dans les fichiers CSS appropriee -->
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
                width: 68.75rem;
                height: 40.625rem;
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

            .erreur{
                color: red;
            }
    </style>


</head>
<body id="conteneur-inscription">
    <div id="inscription">
        <h1>DEVENIR MEMBRE</h1>
        <form id="form-inscription" method="post">
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
                    <p class="erreur"><?php echo $erreur; ?></p><br>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</body>
</html>
