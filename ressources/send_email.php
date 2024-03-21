<?php

// SMTP configuration
ini_set("smtp", "smtp.elasticemail.com");
ini_set("smtp_port", 2525);
ini_set("smtp_username", "cocktailwizard.supp0rt@gmail.com");
ini_set("smtp_password", "159A4A8326842B20BF9D04C0A115EED2F191");

// Sender's email
$from = "cocktailwizard.supp0rt@gmail.com";

// Additional headers
$header = "From: $from";

// Recipient's email
$to = "cocktailwizard.supp0rt@gmail.com";

// Email subject
$subject = "Subject of your email";

// Email content
$content = "Content of your email";

// Send email
if (mail($to, $subject, $content, $header)) {
    echo "Email sent successfully.";
} else {
    echo "Failed to send email.";
}
