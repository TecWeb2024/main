<?php
    //area carrello, ti ridireziona dopo un messaggio con link a fare il login se non sei ancora loggato, forse cambiare sfondo per colori link brutti
    require_once "connection.php";
    require_once "funzioni.php";


    setlocale(LC_ALL, 'it_IT');
    
    $paginaHTML = file_get_contents('carrelloTemplate.html');

    $stringaRiepilogo = "";
    $stringaMessaggio = "";
    $error = "";
    $stringaPagamento = "";

    $stringaMessaggio = '<p class="error_Message">Questa pagina non è ancora disponibile perchè non sei collegato con nessun <span lang="en">account</span>. Ti preghiamo di accedere al tuo <span lang="en">account</span> oppure registrarti dalla pagina <a href="login.php"><span lang="en">Account</span></a>.</p>';

    $paginaHTML = str_replace("{errori}",$error,$paginaHTML);
    $paginaHTML = str_replace("{riepilogoOrdine}",$stringaRiepilogo,$paginaHTML);
    $paginaHTML = str_replace("{formCarrello}",$stringaPagamento,$paginaHTML);
    $paginaHTML = str_replace("{prodottiCarrello}",$stringaMessaggio,$paginaHTML);

    echo $paginaHTML;

?>