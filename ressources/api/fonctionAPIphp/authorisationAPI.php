<?php

i

function userAccesResssource($usernameRequete) {

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        if ($username == $usernameRequete) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
