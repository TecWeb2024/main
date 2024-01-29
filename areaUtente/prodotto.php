<?php
require_once "../connection.php";
use DB\DBAccess;

setlocale(LC_ALL, 'it_IT');

session_start();

$paginaHTML = file_get_contents("templates/prodottoTemplate.html");

$error = "";
$contenuto = "";
$titolo = "";
$keywords = "";
$breadcrumb = "";
$titoloProdotto = "";
$immaginiProdotto = "";
$specificheProdotto = "";
$quantitaProdotto = "";
$carrello = "";
$stringaMessaggio = "";
$descrizioneProdotto = "";
$consegna = "";
$aggiornamento1= "";
$aggiornamento2= "";

$connection = new DBAccess();

if($connection->isLoggedInUser()){ // mancano keywords se null
    if ($connection->openDBConnection()){

        if(isset($_GET['id'])){
            $idProdotto = $_GET['id'];
            $prodotto = $connection->getProdottoById($idProdotto);
        
            if ($prodotto != null){

                $contenuto = '<div id="product_Details"><h3>Specifiche Prodotto</h3>';

                $nomeCategoria = $connection->getCategoriaFromId($prodotto['categoria']);
                $connection->closeDBConnection();

                $categoriaLink = strtolower(str_replace(' ', '', $nomeCategoria));
            
                $breadcrumb = '<a href="index.php"><span lang="en">Home</span></a> &gt; <a href="' . $categoriaLink . '.php"> ' . $nomeCategoria . ' </a> &gt;' . $prodotto['nome'];
            
                $titolo =  $prodotto['nome'];
            
                $keywords = $prodotto['keywords'];
            
                $titoloProdotto = "'. $prodotto['nome'] . '";
            
                $immaginiProdotto =    '<div id="product_Images">Immagini del prodotto
                                    <img src="' . $prodotto['immagine1'] . '" class="immagine_prodotto" alt="">
                                    <img src="' . $prodotto['immagine2'] . '" class="immagine_prodotto" alt="">
                                    <img src="' . $prodotto['immagine3'] . '" class="immagine_prodotto" alt="">
                                    <img src="' . $prodotto['immagine4'] . '" class="immagine_prodotto" alt=""></div>';

                $specificheProdotto = '<ul id="product_Specs"><li><span class="specs_List">Prezzo:</span> '      . $prodotto['prezzo']       . '€</li>
                                    <li><span class="specs_List">Peso:</span> '         . $prodotto['peso']         . '</li> 
                                    <li><span class="specs_List">Dimensioni:</span> '   . $prodotto['dimensione']   . '</li>';
                
                if($prodotto['colore'] != NULL){
                    $specificheProdotto .= '<li><span class="specs_List">Colore:</span> '       . $prodotto['colore']       . '</li>';
                }else{
                    $specificheProdotto .= '<li><span class="specs_List">Colore:</span> Non disponibile';
                }

                if($prodotto['volume'] != NULL){
                    $specificheProdotto .= '<li><span class="specs_List">Volume:</span> '       . $prodotto['volume']       . '</li>';
                }else{
                    $specificheProdotto .= '<li><span class="specs_List">Volume:</span> Non disponibile';
                }

                if($prodotto['materialeUtilizzato'] != NULL){
                    $specificheProdotto .= '<li><span class="specs_List">Materiali:</span> '    . $prodotto['materialeUtilizzato'] . '</li>';
                }else{
                    $specificheProdotto .= '<li><span class="specs_List">Materiali:</span> Non disponibile';
                }

                $specificheProdotto .= '<li><span class="specs_List">Azienda:</span> '      . $prodotto['marca'] . '</li>
                                        <li><span class="specs_List">Categoria:</span> '    . $nomeCategoria . '</li></ul>';
            

                $qnt = $prodotto['quantita']; // controllare come esce
                $quantitaProdotto = '<form action="prodotto.php" class="form" method="post"><div id="cart_Specs">';
                    if($qnt != 0){
                        $quantitaProdotto .= '<p class="cart_List">Seleziona quantità:</p>
                            <select name="opzione_selezionata" id="quantity"> ';
                        for ($i = 1; $i <= $qnt; $i++) {
                            $quantitaProdotto .= '<option value="' . $i . '"> ' . $i . '</option>';
                        }
                        $quantitaProdotto .= ' </select> ';
                    }elseif($qnt == 0){
                        $quantitaProdotto .= '<p> Prodotto esaurito! Ci dispiace per il disagio, presto tornerà disponibile!</p>';
                    }
                $quantitaProdotto .= '</div><input type="submit" name="addToCart" class="button" value="Aggiungi al carrello."></form>';
                     
                $descrizioneProdotto = '<div id="product_Description"><h3>Descrizione</h3><p>' . $prodotto['descrizione'] . '</p></div>';
                
                $consegna = '<div id="delivery_Details"><h3>Dettagli di Consegna</h3><ul id="delivery_List">
                <li>Consegna in 3-5 giorni lavorativi.</li>
                <li>Spedizione gratuita per ordini superiori a 50 €.</li>
                </ul></div> ';

               
                if(isset($_POST['addToCart'])){ // aggiungi al carrello
                    if ($connection->openDBConnection()){
                
                    $quantita_selezionata = $_POST['opzione_selezionata'];
                    $utente_sessione = $_SESSION['user'];
                    
                    $aggiornamento1 = $connection->saveToCart($utente_sessione,$idProdotto,$quantita_selezionata);

                    if($aggiornamento1 == 1){// aggiunto al carrello
                        $aggiornamento2 = $connection->updateProductQuantity($idProdotto,$quantita_selezionata);

                        if($aggiornamento2 == 0){// errato update quantità
                            $query = "";
                            $query = "DELETE FROM carrello WHERE $idProdotto=IDprodotto;";
                            $checkQuery=$connection->modifyDatabase($query);
    
                            if($checkQuery){//DELETE eseguita correttamente
                                $stringaMessaggio = '<p class="error_Message" role="alert">Errore nell\'inserimento nel carrello.</p>';
                            }
                        }else{ //corretto update quantità
                            $stringaMessaggio = '<p class="success_Message" role="alert">Prodotto aggiunto al carrello.</p>';
                        }
                    }else{// non aggiunto al carrello
                        $stringaMessaggio = '<p class="error_Message" role="alert">Errore nell\'inserimento nel carrello.</p>';
                    }
                    $connection->closeDBConnection();
                    $paginaHTML = str_replace("{errori}",$stringaMessaggio,$paginaHTML);

                    }else{
                        $error = DBConnectionError(true);
                    }
                }
        
            }else{ // Prodotto non trovato
                $titolo = 'Prodotto Non Trovato';
                $breadcrumb = '<a href="index.php"><span lang="en">Home</span></a> &gt; Errore prodotto non trovato';
                $titoloProdotto = 'Prodotto non trovato';
                $error = '<p>Il prodotto selezionato non è più presente nei nostri magazzini.</p>';
            }
            $contenuto .= '</div>'

        }else{ // ID non valido, ID non presente nel database
            $error = '<p>Nessun prodotto che abbiamo attualmente nei nostri magazzini corrisponde a quello selezionato.</p>';
        }

        $connection->closeDBConnection();
        $paginaHTML = str_replace("{errori}",$error,$paginaHTML);
        $paginaHTML = str_replace("{titolo}", $titolo, $paginaHTML);
        $paginaHTML = str_replace("{keywords}", $keywords, $paginaHTML);
        $paginaHTML = str_replace("{breadcrumb}", $breadcrumb, $paginaHTML);
        $paginaHTML = str_replace("{titoloProdotto}", $titoloProdotto, $paginaHTML); 
        $paginaHTML = str_replace("{immaginiProdotto}", $immaginiProdotto, $paginaHTML);
        $paginaHTML = str_replace("{contenutoProdotto}", $contenuto, $paginaHTML);
        $paginaHTML = str_replace("{specificheProdotto}", $specificheProdotto, $paginaHTML);
        $paginaHTML = str_replace("{quantitaProdotto}", $quantitaProdotto, $paginaHTML);
        $paginaHTML = str_replace("{descrizioneProdotto}", $descrizioneProdotto, $paginaHTML);
        $paginaHTML = str_replace("{carrello}", $carrello, $paginaHTML);
        $paginaHTML = str_replace("{consegna}", $consegna, $paginaHTML);

    }else{
        $error = DBConnectionError(true);
        $paginaHTML = str_replace("{errori}",$error,$paginaHTML);
        $paginaHTML = str_replace("{titolo}", $titolo, $paginaHTML);
        $paginaHTML = str_replace("{keywords}", $keywords, $paginaHTML);
        $paginaHTML = str_replace("{breadcrumb}", $breadcrumb, $paginaHTML);
        $paginaHTML = str_replace("{titoloProdotto}", $titoloProdotto, $paginaHTML);
        $paginaHTML = str_replace("{immaginiProdotto}", $immaginiProdotto, $paginaHTML);
        $paginaHTML = str_replace("{contenutoProdotto}", $contenuto, $paginaHTML);
        $paginaHTML = str_replace("{specificheProdotto}", $specificheProdotto, $paginaHTML);
        $paginaHTML = str_replace("{quantitaProdotto}", $quantitaProdotto, $paginaHTML);
        $paginaHTML = str_replace("{descrizioneProdotto}", $descrizioneProdotto, $paginaHTML);
        $paginaHTML = str_replace("{carrello}", $carrello, $paginaHTML);
        $paginaHTML = str_replace("{consegna}", $consegna, $paginaHTML);
    }
}else{
    //ridirezionamento fuori areaUtente
    header("Location: ../index.php");
    die();
}

echo $paginaHTML;

?>

