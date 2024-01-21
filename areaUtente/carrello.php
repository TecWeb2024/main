<?php
    //qui puoi accedere al carrello normalmente
    require_once "../connection.php";
    require_once "../funzioni.php";
    session_start();

    use DB\DBAccess;
    $connection = new DBAccess();

    setlocale(LC_ALL, 'it_IT');
    
    $paginaHTML = file_get_contents('../carrelloTemplate.html');

    $stringaRiepilogo = "";
    $stringaMessaggio = "";
    $error = "";
    $listaProdotti = "";
    $stringaProdotti = "";
    
    $prezzoParziale = 0;
    $prezzoSpedizione = 0; //se prezzoParziale >50 questa variabile resta 0; altrimenti diventa 7
    $prezzoTotale = 0;
    $numeroProdotti = 0;

    if($connection->isLoggedInUser()){
        if($connection->openDBConnection()){ // connessione aperta
            $risultato=array();
            // Chiamata alla funzione
            $id = $_SESSION['user'];

            $risultato = $connection->getRiepilogoFromDatabase($id);
            $listaProdotti = $connection->getProdottiCarrello($id);//cambiare funzione


            $connection->closeDBConnection();
           
            if($listaProdotti != null && $risultato != null) {

                $prezzoParziale = (array_values($risultato[0])[0]);
                $numeroProdotti = (array_values($risultato[1])[0]);

                $prezzoParziale>50 ? $prezzoSpedizione=0 : $prezzoSpedizione=7;

                $prezzoTotale = $prezzoParziale + $prezzoSpedizione;

                $stringaRiepilogo .= '<dd>Prezzo parziale: ' .$prezzoParziale.'€</dd><dd>Costo spedizione: ' .$prezzoSpedizione.'€</dd> <dd>Totale: ' .$prezzoTotale.' € ( ' .$numeroProdotti.' articoli selezionati)</dd>';
           
                foreach ($listaProdotti as $prodotti) { // aggiungere alt
                    $stringaProdotti .='<li><a href="prodotto.php?id=' . $prodotti["IDprodotto"] . '"><img src="' . $prodotti["immagine1"] . '" alt=""><div class="product_Info"><p>' . $prodotti["nome"] . ' € ' . $prodotti["prezzo"] . '</p>
                    <p>Quantità: ' . $prodotti["quantita"] . '</p></a><input type="submit" name="submit" class="accountButton" value="Rimuovi prodotto"></div></li>';
                }
            }else{
                $stringaRiepilogo = "<dd>Prezzo Parziale: 0€</dd><dd>Costo spedizione: 0€</dd><dd>Totale: 0€ (0 articoli selezionati)</dd> ";
                $stringaProdotti .= "<li>Non sono presenti prodotti nel tuo carrello.</li>";
            }

            if(isset($_POST['shopButton'])){
                if($listaProdotti != null){
                    if($connection->openDBConnection()){

                        $query = "DELETE FROM carrello WHERE IDutente=$id;";
                        $checkQuery=$connection->modifyDatabase($query);
                        if($checkQuery){
                            $stringaRiepilogo = "<dd>Prezzo Parziale: 0€</dd><dd>Costo spedizione: 0€</dd><dd>Totale: 0€ (0 articoli selezionati)</dd> ";
                            $stringaProdotti = "<li>Non sono presenti prodotti nel tuo carrello.</li>";

                            $errori = '<p class="success_Message" role="alertdialog">Acquisto effettuato con successo.</p>';
   
                        }else{
                            
                            $error = '<p class="error_Message" role="alertdialog">Per fare un acquisto devi avere almeno un prodotto nel tuo carrello</p>' ;
                   
                        }

                    $connection->closeDBConnection();
                             
                    }else{
                        $error .= DBConnectionError(true);
                    }

                }else{
                    $error = '<p class="error_Message" role="alertdialog">Per fare un acquisto devi avere almeno un prodotto nel tuo carrello</p>' ;
                }
            }

            $paginaHTML = str_replace("{errori}",$error,$paginaHTML);
            $paginaHTML = str_replace("{riepilogoOrdine}",$stringaRiepilogo,$paginaHTML);
            $paginaHTML = str_replace("{prodottiCarrello}",$stringaProdotti,$paginaHTML);

        }else{
            $error .= DBConnectionError(true);
            $paginaHTML = str_replace("{errori}",$error,$paginaHTML);
            $paginaHTML = str_replace("{riepilogoOrdine}",$stringaRiepilogo,$paginaHTML);
            $paginaHTML = str_replace("{prodottiCarrello}",$stringaProdotti,$paginaHTML);
        }
    }    
    elseif($connection->isLoggedInAdmin()){
        $stringaMessaggio = '<p class="error_Message" role="alertdialog">Questa pagina non è disponibile perché sei collegato con l\'<span lang="en">account</span> amministratore. Per regola, un amministratore non può usufruire del carrello. Ti preghiamo di accedere con un <span lang="en">account</span> utente.</p>';
        $paginaHTML = str_replace("{errori}",$error,$paginaHTML);
        $paginaHTML = str_replace("{riepilogoOrdine}",$stringaRiepilogo,$paginaHTML);
        $paginaHTML = str_replace("{prodottiCarrello}",$stringaProdotti,$paginaHTML);
    }
    else{ //ridirezionamento fuori areaAdmin
        header("Location: ../index.php");
        die();
    }
    
    echo $paginaHTML;

?>