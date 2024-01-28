<?php

use DB\DBAccess;

require_once('connection.php');

    function sanitizeInput($input) {
        
        $input = strip_tags($input); // Rimuove eventuali tag HTML non consentiti

        $input = htmlentities($input, ENT_QUOTES, 'UTF-8'); // Applica htmlentities per prevenire XSS
    
        $input = stripslashes($input); // Rimuove eventuali barre invertite
    
        $input = preg_replace('/\s+/', ' ', $input); // Rimuove eventuali spazi multipli

        $input = trim($input);  // Elimina spazi bianchi all'inizio e alla fine della stringa

        return $input;
    }

    function DBConnectionError(bool $uscita = false){
        return '<p class="errorDB" role="alert">I sistemi sono momentaneamente fuori servizio. Ci scusiamo per il disagio.
                Torna alla <a href="'.($uscita?'../':'').'index.php">Home</a> o riprova più tardi.</p>'; //da modificare la struttura della cartella main
    }


?>