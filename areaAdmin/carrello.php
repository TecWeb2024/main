<?php
    //area carrello, ti ridireziona dopo un messaggio con link a fare il login se non sei ancora loggato, forse cambiare sfondo per colori link brutti
    require_once "../connection.php";
    require_once "../funzioni.php";
    session_start();

    use DB\DBAccess;
    setlocale(LC_ALL, 'it_IT');

    $connection = new DBAccess();
    
    $paginaHTML = file_get_contents('templates/carrelloTemplate.html');

    $stringaRiepilogo = "";
    $stringaMessaggio = "";
    $error = "";
    $stringaPagamento = "";

    if($connection->isLoggedInAdmin()){
        //non puoi comprare
    $stringaMessaggio = '<p class="error_Message">Questa pagina non è disponibile perché sei collegato con l\'<span lang="en">account</span> amministratore. Per regola, un amministratore non può usufruire del carrello. Ti preghiamo di accedere con un <span lang="en">account</span> utente.</p>';

    }
    else{ //ridirezionamento fuori areaAdmin
        header("Location: ../index.php");
        die();
    }
    $paginaHTML = str_replace("{errori}",$error,$paginaHTML);
    $paginaHTML = str_replace("{riepilogoOrdine}",$stringaRiepilogo,$paginaHTML);
    $paginaHTML = str_replace("{formCarrello}",$stringaPagamento,$paginaHTML);
    $paginaHTML = str_replace("{prodottiCarrello}",$stringaMessaggio,$paginaHTML);

    echo $paginaHTML;

?>