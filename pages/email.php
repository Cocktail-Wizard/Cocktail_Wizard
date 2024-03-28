<?php

/**
 * Source : https://github.com/PHPMailer/PHPMailer/blob/master/examples/gmail.phps
 *
 * Ceci est un exemple de script PHP qui permet d'envoyer un courriel en utilisant
 * la librairie PHPMailer. De plus, ce script utilise le serveur SMTP de Gmail pour
 * envoyer le courriel.
 *
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

/**
 * Identification et configuration.
 *
 *  - identifiant     : identifiant de connexion (adresse courriel Gmail)
 *  - motDePasse      : mot de passe de connexion (mot de passe de l'application)
 *
 *  - source          : adresse courriel de l'expéditeur (c.-à-d. votre adresse Gmail)
 *  - destinataire    : adresse courriel du destinataire
 *  - nomEnvoyeur     : nom de l'expéditeur
 *  - nomDestinataire : nom du destinataire
 */

$identifiant = 'cocktailwizard.supp0rt@gmail.com';
$motDePasse = 'xmfmkshoknqxtczp';

$source = 'cocktailwizard.supp0rt@gmail.com';
$destinataire = 'cocktailwizard.supp0rt@gmail.com';
$nomEnvoyeur = 'Utilisateur';
$nomDestinataire = 'Support';

/**
 * Message à envoyer.
 */

$sujetMessage = 'Test PHPMailer';
$corpsMessage = 'Ceci est un test!';

// Instancier le client
$mail = new PHPMailer();

// Activer le mode SMTP
$mail->isSMTP();

// Options de déboguage :
//   SMTP::DEBUG_OFF    = pas de déboguage
//   SMTP::DEBUG_CLIENT = client seulement
//   SMTP::DEBUG_SERVER = client et serveur
$mail->SMTPDebug = SMTP::DEBUG_SERVER;

// Définir le nom d'hôte
$mail->Host = 'smtp.gmail.com';

// Fixer le port du serveur (valeur par défaut pour Gmail : 465)
$mail->Port = 465;

// Mécanisme de chiffrement (configuration par défaut qui dépend de Gmail) :
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

// Activer l'authentification
$mail->SMTPAuth = true;

// Informations de connexion (https://myaccount.google.com/apppasswords)
$mail->Username = $identifiant;
$mail->Password = $motDePasse;

/*
 * Contenu du message.
*/

// Adresse d'envoi
$mail->setFrom($source, $nomEnvoyeur);

// Adresse de retour
$mail->addReplyTo($source, $nomEnvoyeur);

// Adresse destinataire
$mail->addAddress($destinataire, $nomDestinataire);

// Sujet du message
$mail->Subject =  $sujetMessage;

// Corps du message
$mail->Body = $corpsMessage;

if (!$mail->send()) {
    echo 'Erreur: ' . $mail->ErrorInfo;
} else {
    echo 'Message envoyé!';
}
