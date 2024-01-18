<?php
require_once "connection.php";
use DB\DBAccess;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("prodottoTemplate.html");
$stringaProdotto = "";
$listaProdotto = "";

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $idProdotto = $_GET['id'];
        $prodotto = $connection->getProdottoById($idProdotto);

        if ($prodotto != null){

            //HEADER
            $titolo =  $prodotto['nome'];
            $keywords = $prodotto['keywords'];
            $titoloProdotto =      '<h2>' . $prodotto['nome'] . '</h2>';
            
            $immaginiProdotto =    '<img src="' . $prodotto['immagine1'] . '" class="grid_Image" alt=' . $prodotto['descrizione'] .'>
                                    <img src="' . $prodotto['immagine2'] . '" class="grid_Image" alt=' . $prodotto['descrizione'] .'>
                                    <img src="' . $prodotto['immagine3'] . '" class="grid_Image" alt=' . $prodotto['descrizione'] .'>
                                    <img src="' . $prodotto['immagine4'] . '" class="grid_Image" alt=' . $prodotto['descrizione'] .'>'; 
        
            $specificheProdotto =  '<li><span class="specs_List">Prezzo:</span> '       . $prodotto['prezzo']       . '€</li>
                                    <li><span class="specs_List">Peso:</span> '         . $prodotto['peso']         . '</li> 
                                    <li><span class="specs_List">Dimensioni:</span> '   . $prodotto['dimensione']   . '</li>
                                    <li><span class="specs_List">Colore:</span> '       . $prodotto['colore']       . '</li>
                                    <li><span class="specs_List">Volume:</span> '       . $prodotto['volume']       . ' L</li>
                                    <li><span class="specs_List">Materiali:</span> '    . $prodotto['materialeUtilizzato'] . '</li>
                                    <li><span class="specs_List">Azienda:</span> '      . $prodotto['marca']        . '</li>';
            
            
            $descrizioneProdotto= '<p>' . $prodotto['descrizione'] . '</p>';
            //Quantità prodotto
            $qnt = $prodotto['quantita'];
            $quantitaProdotto = '';
            for ($i = 0; $i <= $qnt; $i++) {
                $quantitaProdotto .= '<option value="' . $i . '"> ' . $i . '</option>';
            }

            //Taglia Prodotto DA TOGLIERE ?
            $tagliaProdotto = '1';


            //replacement
            $paginaHTML = file_get_contents("prodottoTemplate.html");
            //header
            $paginaHTML = str_replace("{titolo}",   $titolo, $paginaHTML);
            $paginaHTML = str_replace('{keywords}',   $keywords, $paginaHTML);
            //body

            
            $paginaHTML = str_replace("{titoloProdotto}",   $titoloProdotto, $paginaHTML);
            $paginaHTML = str_replace("{immaginiProdotto}", $immaginiProdotto, $paginaHTML);
            $paginaHTML = str_replace("{specificheProdotto}", $specificheProdotto, $paginaHTML);
            $paginaHTML = str_replace("{quantitaProdotto}", $quantitaProdotto, $paginaHTML);
            $paginaHTML = str_replace("{tagliaProdotto}",   $tagliaProdotto, $paginaHTML);
            $paginaHTML = str_replace("{descrizioneProdotto}", $descrizioneProdotto, $paginaHTML);
        
            echo $paginaHTML;
            

        } else {
            echo "Prodotto non trovato.";
        }
        
    } else {
        echo "ID del prodotto non valido.";
    }

    $connection->closeDBConnection();
} else {
    echo "Errore di connessione al database.";
}
?>

