<?php
require_once "connection.php";
use DB\DBAccess;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

session_start();

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
            $NomeCategoria = $connection->getCategoriaFromId($prodotto['categoria']);
            $categoriaLink = strtolower(str_replace(' ', '', $NomeCategoria));
            $breadcrumb = '<a href="index.php"><span lang="en">Home</span></a> &gt; <a href="' . $categoriaLink . '.php"> ' . $NomeCategoria . ' </a> &gt;' . $prodotto['nome'];
            $titolo =  $prodotto['nome'];
            $keywords = $prodotto['keywords'];
            $titoloProdotto =      '<h2>' . $prodotto['nome'] . '</h2>';
            $immaginiProdotto =    '<img src="' . $prodotto['immagine1'] . '" class="immagine_prodotto" alt=' . $prodotto['descrizione'] .'>
                                    <img src="' . $prodotto['immagine2'] . '" class="immagine_prodotto" alt=' . $prodotto['descrizione'] .'>
                                    <img src="' . $prodotto['immagine3'] . '" class="immagine_prodotto" alt=' . $prodotto['descrizione'] .'>
                                    <img src="' . $prodotto['immagine4'] . '" class="immagine_prodotto" alt=' . $prodotto['descrizione'] .'>'; 
            $specificheProdotto =  '<li><span class="specs_List">Prezzo:</span> '       . $prodotto['prezzo']       . '€</li>
                                    <li><span class="specs_List">Peso:</span> '         . $prodotto['peso']         . '</li> 
                                    <li><span class="specs_List">Dimensioni:</span> '   . $prodotto['dimensione']   . '</li>
                                    <li><span class="specs_List">Colore:</span> '       . $prodotto['colore']       . '</li>
                                    <li><span class="specs_List">Volume:</span> '       . $prodotto['volume']       . ' L</li>
                                    <li><span class="specs_List">Materiali:</span> '    . $prodotto['materialeUtilizzato'] . '</li>
                                    <li><span class="specs_List">Azienda:</span> '      . $prodotto['marca'] . '</li>
                                    <li><span class="specs_List">Categoria:</span> '    . $connection->getCategoriaFromId($prodotto['categoria']) . '</li>';
            $descrizioneProdotto= '<p>' . $prodotto['descrizione'] . '</p>';
            

            // Quantità prodotto
            $qnt = $prodotto['quantita'];
            $quantitaProdotto = '';
            if($qnt != 0){
                $quantitaProdotto .= '<span class="cart_List">Seleziona quantità:</span>
                                      <select name="opzione_selezionata" id="quantity"> ';
                for ($i = 1; $i <= $qnt; $i++) {
                    $quantitaProdotto .= '<option value="' . $i . '"> ' . $i . '</option>';
                }
                $quantitaProdotto .= ' </select> ';
            }else if($qnt == 0){
                $quantitaProdotto .= '<p> Prodotto esaurito! Ci dispiace per il disagio, presto tornerà disponibile!</p>';
            }
            

            // Carrello dinamico
            $carrello='';
            if($connection->isLoggedInUser() &&  $qnt > 0){
                $carrello = '<input type="submit" name="addToCart" class="button" value="Aggiungi al carrello.">';
            }
            if($connection->isLoggedInAdmin()){
                $carrello = '<p>Sei registrato come Amministratore. Le funzionalità del carrello sono disabilitate.</p>';
            }
            if(!($connection->isLoggedInAdmin()) && !($connection->isLoggedInUser())){
                $carrello = '<p>Effettua il login per poter effettuare i tuoi acquisti: <a href="login.php"><span lang="en">Account</span></a></p>';
            }
            if(isset($_POST['addToCart'])){
                if($connection->isLoggedInUser() || $connection->isLoggedInAdmin()){
                    $quantita_selezionata = $_POST['opzione_selezionata'];
                    $utente_sessione = $_SESSION['user'];
                    $connection->saveToCart($utente_sessione,$idProdotto,$quantita_selezionata);
                    $connection->updateProductQuantity($idProdotto,$quantita_selezionata);
                    echo '<script>window.location.href = "carrello.php";</script>';
                   
                    
                }elseif(!$connection->isLoggedInUser() || $connection->isLoggedInAdmin()){
                    //echo "non connesso";
                    
                }else{
                    //echo "Errore addToCart";
                }
            }

            //REPLACEMENT
            $paginaHTML = file_get_contents("prodottoTemplate.html");
            $paginaHTML = str_replace("{titolo}",   $titolo, $paginaHTML);
            $paginaHTML = str_replace('{keywords}',   $keywords, $paginaHTML);
            $paginaHTML = str_replace("{breadcrumb}",   $breadcrumb, $paginaHTML);
            $paginaHTML = str_replace("{titoloProdotto}",   $titoloProdotto, $paginaHTML);
            $paginaHTML = str_replace("{immaginiProdotto}", $immaginiProdotto, $paginaHTML);
            $paginaHTML = str_replace("{specificheProdotto}", $specificheProdotto, $paginaHTML);
            $paginaHTML = str_replace("{quantitaProdotto}", $quantitaProdotto, $paginaHTML);
            $paginaHTML = str_replace("{descrizioneProdotto}", $descrizioneProdotto, $paginaHTML);
            $paginaHTML = str_replace("{carrello}", $carrello, $paginaHTML);
            
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

