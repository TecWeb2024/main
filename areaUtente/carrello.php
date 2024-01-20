<?php
    //qui puoi accedere al carrello normalmente
    require_once "../connection.php";
    require_once "../funzioni.php";
    session_start();

    use DB\DBAccess;
    $connection = new DBAccess();

    setlocale(LC_ALL, 'it_IT');
    
    $paginaHTML = file_get_contents('carrelloTemplate.html');

    $stringaRiepilogo = "";
    $stringaMessaggio = "";
    $DBerror = "";
    
    $prezzoParziale = 0;
    $prezzoSpedizione = 0; //se prezzoParziale >50 questa variabile resta 0; altrimenti diventa 7
    $prezzoTotale = 0;
    $numeroProdotti = 0;

    
    <li>Prezzo parziale: 0€</li>
        <li>Costo spedizione: 0€</li>
        <li>Totale: 0€ (0 articoli selezionati)</li>


    if($connection->isLoggedInUser()){
        if($connection->openDBConnection()){

            return {a,b}

            {prezzoparziale,numeroprodotti}=funzione{prezzoparziale,numeroprodotti}
            $stringaRiepilogo .= '<li>Prezzo parziale:' .$prezzoParziale.'€</li><li>Costo spedizione:' .$prezzoSpedizione.'€</li> <li>Totale: ' .$prezzoTotale.'€ (' .$numeroProdotti.' articoli selezionati)</li>';


        }else{
            $DBerror .= DBConnectionError(true);
            $paginaHTML = str_replace("{errori}",$DBerror,$paginaHTML);
            $paginaHTML = str_replace("{riepilogoOrdine}",$stringaRiepilogo,$paginaHTML);
            $paginaHTML = str_replace("{prodottiCarrello}",$stringaMessaggio,$paginaHTML);
        }
    }    
    elseif($connection->isLoggedInAdmin()){
        $stringaMessaggio = '<p class="error_Message">Questa pagina non è disponibile perché sei collegato con l''<span lang="en">account</span> amministratore. Per regola, un amministratore non può usufruire del carrello. Ti preghiamo di accedere con un <span lang="en">account</span> utente.</p>';
        $paginaHTML = str_replace("{errori}",$DBerror,$paginaHTML);
        $paginaHTML = str_replace("{riepilogoOrdine}",$stringaRiepilogo,$paginaHTML);
        $paginaHTML = str_replace("{prodottiCarrello}",$stringaMessaggio,$paginaHTML);
    }
    else{ //ridirezionamento fuori areaAdmin
        header("Location: ../index.php");
        die();
    }
    
    echo $paginaHTML;

?>