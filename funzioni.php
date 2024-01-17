<?php
/*PER ORA INUTILE TUTTO QUESTO FILE*/
use DB\DBAccess;

require_once('connection.php');

function sanitizeInput($input) {
    // Rimuove eventuali tag HTML non consentiti
    $input = strip_tags($input);

    // Applica htmlentities per prevenire XSS se $allowed_tags è vuoto o non fornito
    $input = htmlentities($input, ENT_QUOTES, 'UTF-8');
    
    // Rimuove eventuali barre invertite
    $input = stripslashes($input);

    // Rimuove eventuali spazi multipli
    $input = preg_replace('/\s+/', ' ', $input);

    // Elimina spazi bianchi all'inizio e alla fine della stringa
    $input = trim($input);

    return $input;
}


?>