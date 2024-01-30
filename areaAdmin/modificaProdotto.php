<?php
    require_once "../connection.php";
    require_once "../funzioni.php";
    use DB\DBAccess;

    setlocale(LC_ALL, 'it_IT');
    session_start();

    $paginaHTML = file_get_contents("templates/modificaProdottoTemplate.html");
    $error = "";
    $risultatoQuery = "";
    $listaCategoria = "";
    $stringaCategoria = "";
    $listaMarca = "";
    $stringaMarca= "";
    $stringaErrori = "";
    $stringaQuery = "";
    $ID = "";
    
    $nuova_categoria = "";
    $nuovo_prezzo = "";
    $nuovo_peso ="";
    $nuova_dimensione = "";
    $nuovo_colore = "";
    $nuovo_volume ="";
    $nuovo_materiale_utilizzato = "";
    $nuova_quantita = "";
    $nuova_descrizione = "";
    $nuove_keywords = "";
    $nuova_marca = "";
    $nuovo_alt = "";
    
    $err = [];

    $connection = new DBAccess();
    if($connection->isLoggedInAdmin()){
        if($connection->openDBConnection()){

            $result = $connection->getProductsFromDatabase();
            $connection->closeDBconnection();

            $prodotto_da_modificare = NULL;

            $scelta = "";
            $modifica = "";
            if($result != null) {
                foreach($result as $prodotto){
                    $scelta .= '<option value=' .$prodotto['ID']. '>' . $prodotto['nome'] . '</option>';
                }
            }else{
                $scelta = '<option value="0" disabled>Non ci sono prodotti</option>';
            }

        }else{
            $error = DBConnectionError(true);
            $paginaHTML = str_replace("{scegliProdotto}", $scelta, $paginaHTML);
            $paginaHTML = str_replace("{modifica}", $error, $paginaHTML);
        }

        if(isset($_POST["conferma_modifica"])){
            if($result != null){
                $id_prodotto_modifica = $_POST["lista_prodotti_modifica"];

                if($connection->openDBConnection()){

                    $prodotto_da_modificare = $connection->getProdottoById($id_prodotto_modifica);
                    $listaCategoria = $connection->getCategoriesFromDatabase();
                    $listaMarca = $connection->getMarcaFromDatabase();

                    $connection->closeDBconnection();

                    if($prodotto_da_modificare != null) {
                        if ($listaCategoria != null) {
                            foreach ($listaCategoria as $cate) {
                                $stringaCategoria .= '<option value="'.$cate['ID'].'">'.$cate['nome'].'</option>';
                            }
                        } else {
                            $stringaCategoria = '<option value="0" disabled>Non sono presenti categorie</option>';
                        }
            
                        if ($listaMarca != null) {
                            foreach ($listaMarca as $mar) {
                                $stringaMarca .= '<option value="'.$mar['ID'].'">'.$mar['nome'].'</option>';
                            }
                        } else {
                            $stringaMarca = '<option value="0" disabled>Non sono presenti marche</option>';
                        }

                        foreach($prodotto_da_modificare as $prod){
                        $ID = $prod['ID'];

                        $scelta = '<option value=' .$prod['ID']. '>' . $prod['nome'] . '</option>';

                        $modifica = '<h3> Modifica - ' . $prod['nome'] . '</h3>
                        <label for="nome_mod">Nome:</label>
                        <input type="text" id="nome_mod" name="nome_mod" value="' . $prod['nome'] . '" required>
                        <!--
                        <label for="immagine1_mod">Immagine in Alto a Sinistra:</label>
                        <input type="file" id="immagine1_mod" name="immagine1_mod" accept="image/*">
                        <img src="../' . $prod['immagine1'] . '" alt="" required>
                        
                        <label for="immagine2_mod">Immagine in Alto a Destra:</label>
                        <input type="file" id="immagine2_mod" name="immagine2_mod" accept="image/*">
                        <img src="../' . $prod['immagine2'] . '" alt="" required>
                        
                        <label for="immagine3_mod">Immagine in Basso a Sinistra:</label>
                        <input type="file" id="immagine3_mod" name="immagine3_mod" accept="image/*">
                        <img src="../' . $prod['immagine3'] . '" alt="" required>
                        
                        <label for="immagine4_mod">Immagine in Basso a Destra:</label>
                        <input type="file" id="immagine4_mod" name="immagine4_mod" accept="image/*">
                        <img src="../' . $prod['immagine4'] . '" alt="" required> -->
                        
                        <label for="categoria_mod">Categoria:</label>
                        <select id="categoria_mod" name="categoria_mod" required>
                        {selezioneCategoria}
                        </select>

                        <label for="prezzo_mod">Prezzo:</label>
                        <input type="number" id="prezzo_mod" name="prezzo_mod" step="0.01" value="' . $prod['prezzo'] . '" required>

                        <label for="peso_mod">Peso:</label>
                        <input type="text" id="peso_mod" name="peso_mod" value="' . $prod['peso'] . '" required>

                        <label for="dimensione_mod">Dimensione:</label>
                        <input type="text" id="dimensione_mod" name="dimensione_mod" value="' . $prod['dimensione'] . '" required>
                                
                        <label for="colore_mod">Colore:</label>
                        <input type="text" id="colore_mod" name="colore_mod" value="' . $prod['colore'] . '">
                                
                        <label for="volume_mod">Volume:</label>
                        <input type="text" id="volume_mod" name="volume_mod" value="' . $prod['volume'] . '">

                        <label for="materialeUtilizzato_mod">Materiale Utilizzato:</label>
                        <input type="text" id="materialeUtilizzato_mod" name="materialeUtilizzato_mod" value="' . $prod['materialeUtilizzato'] . '">
                           
                        <label for="quantita_mod">Quantità:</label>
                        <input type="number" id="quantita_mod" name="quantita_mod" value="' . $prod['quantita'] . '" required>       
                                
                        <label for="descrizione_mod">Descrizione:</label>
                        <textarea id="descrizione_mod" name="descrizione_mod" cols="30" rows="5" required>' . $prod['descrizione'] . '</textarea>
                        
                        <label for="keywords_mod"><span lang="en">Keywords</span>:</label>
                        <textarea id="keywords_mod" name="keywords_mod" cols="30" rows="5">' . $prod['keywords'] . '</textarea>
                
                        <label for="alt_mod">Breve Descrizione di Supporto:</label>
                        <textarea id="alt_mod" name="alt_mod"  cols="30" rows="5" required>'. $prod['alt'].'</textarea>
                        
                        <label for="marca_mod">Marca:</label>
                        <select id="marca_mod" name="marca_mod" required>        
                        {selezioneMarca}
                        </select>';
                        }
                        
                        
                    }else{
                        $error = '<p class="error_Message" role="alert">Errore di caricamento del prodotto</p>'; 
                        $paginaHTML = str_replace("{scegliProdotto}", $scelta, $paginaHTML);
                        $paginaHTML = str_replace("{modifica}", $error, $paginaHTML);
                    }
                    
                    
                    if(isset($_POST["submit_modifica"])){ 
                        echo 1;
                        $prodotto_references = $connection->getProdottoById($_POST['id_mod']);
                        /*$connection->removeProductById($_POST['id_mod']);*/

                        $nuovo_nome = sanitizeInput($_POST['nome_mod']);

                        /*if(empty($_FILES['immagine1_mod']['name'])) {
                            $nuova_immagine1 = $prodotto_references['immagine1'];
                        }else{
                            $nuova_immagine1 = 'images/' . sanitizeInput(basename($_FILES['immagine1_mod']['name']));
                            move_uploaded_file(sanitizeInput($_FILES['immagine1_mod']['tmp_name']), $nuova_immagine1);
                        }

                        if(empty($_FILES['immagine2_mod']['name'])) {
                            $nuova_immagine2 = $prodotto_references['immagine2'];
                        }else{
                            $nuova_immagine2 = 'images/' . sanitizeInput(basename($_FILES['immagine2_mod']['name']));
                            move_uploaded_file(sanitizeInput($_FILES['immagine2_mod']['tmp_name']), $nuova_immagine2);
                        }

                        if(empty($_FILES['immagine3_mod']['name'])) {
                            $nuova_immagine3 = $prodotto_references['immagine3'];
                        }else{
                            $nuova_immagine3 = 'images/' . sanitizeInput(basename($_FILES['immagine3_mod']['name']));
                            move_uploaded_file(sanitizeInput($_FILES['immagine3_mod']['tmp_name']), $nuova_immagine3);
                        }

                        if(empty($_FILES['immagine4_mod']['name'])) {
                            $nuova_immagine4 = $prodotto_references['immagine4'];
                        }else{
                            $nuova_immagine4 = 'images/' . sanitizeInput(basename($_FILES['immagine4_mod'])['name']);
                            move_uploaded_file(sanitizeInput($_FILES['immagine4_mod']['tmp_name']), $nuova_immagine4);
                        }*/
                
                        $nuova_categoria = sanitizeInput($_POST['categoria_mod']);
                        $nuovo_prezzo = sanitizeInput($_POST['prezzo_mod']);
                        $nuovo_peso = sanitizeInput($_POST['peso_mod']);
                        $nuova_dimensione = sanitizeInput($_POST['dimensione_mod']);
                        $nuovo_colore = sanitizeInput($_POST['colore_mod']);
                        $nuovo_volume = sanitizeInput($_POST['volume_mod']);
                        $nuovo_materiale_utilizzato = sanitizeInput($_POST['materialeUtilizzato_mod']);
                        $nuova_quantita = sanitizeInput($_POST['quantita_mod']);
                        $nuova_descrizione = sanitizeInput($_POST['descrizione_mod']);
                        $nuove_keywords = sanitizeInput($_POST['keywords_mod']);
                        $nuova_marca = sanitizeInput($_POST['marca_mod']);
                        $nuovo_alt = sanitizeInput($_POST['alt_mod']);

                        /*$maxSize = 1024 * 1024;
            
                        $fileSize1 = $_FILES['immagine1_mod']['size'];
         
                        $fileSize2 = $_FILES['immagine2_mod']['size'];

                        $fileSize3 = $_FILES['immagine3_mod']['size'];

                        $fileSize4 = $_FILES['immagine4_mod']['size'];*/

                        if(!preg_match('/\w{3,}/',$nuovo_nome)){ 
                            echo 2;
                            array_push($err,'<p class="error_Message" role="alert">Nome del prodotto deve essere maggiore di 3 lettere.</p>');
                        }
                        /*if($fileSize1 > $maxSize){
                            array_push($err,'<p class="error_Message" role="alert">Immagine 1 deve essere inferiore ad un <span>megabyte</span>.</p>');
                        }
                        if($fileSize2 > $maxSize){
                            array_push($err,'<p class="error_Message" role="alert">Immagine 2 deve essere inferiore ad un <span>megabyte</span>.</p>');
                        }
                        if($fileSize3 > $maxSize){ 
                            array_push($err,'<p class="error_Message" role="alert">Immagine 3 deve essere inferiore ad un <span>megabyte</span>.</p>');
                        }
                        if($fileSize4 > $maxSize){ 
                            array_push($err,'<p class="error_Message" role="alert">Immagine 4 deve essere inferiore ad un <span>megabyte</span>.</p>');
                        }*/
                        if($nuova_categoria < 0){ 
                            array_push($err,'<p class="error_Message" role="alert">Non sono presenti categorie nel nostro sistema.</p>');
                        }
                        if($nuovo_prezzo < 0){ 
                            array_push($err,'<p class="error_Message" role="alert">Non si possono inserire prodotti con prezzo minore o uguale a zero.</p>');
                        }
                        if(!preg_match('/\w{2,}/',$nuovo_peso)){ 
                            array_push($err,'<p class="error_Message" role="alert">Peso inserito non corretto.</p>');
                        }
                        if(!preg_match('/\w{2,}/',$nuova_dimensione)){ 
                            array_push($err,'<p class="error_Message" role="alert">Dimensione inserita non corretta.</p>');
                        }
                        if($nuova_quantita < 0){ 
                            array_push($err,'<p class="error_Message" role="alert">Quantità non può essere minore o uguale a zero.</p>');
                        }
                        if(strlen($nuova_descrizione)<25){
                            array_push($err,'<p class="error_Message" role="alert">Descrizione deve essere superiore a 25 caratteri.</p>');
                        }
                        if($nuova_marca < 0){ 
                            array_push($err,'<p class="error_Message" role="alert">Non sono presenti marche nel nostro sistema.</p>');
                        }
                        if(strlen($nuovo_alt)<5 && strlen($nuovo_alt)>75){ 
                            array_push($err,'<p class="error_Message" role="alert">Breve descrizione di supporto deve essere almeno di 5 caratteri e non superiore a 75 caratteri.</p>');
                        }
                    
                        if(count($err)==0){
                            echo 3;
                            $query = "";
                            $query = "UPDATE prodotto SET 
                                        nome='$nuovo_nome', 
                                        categoria='$nuova_categoria', 
                                        keywords='$nuove_keywords', 
                                        prezzo='$nuovo_prezzo', 
                                        peso='$nuovo_peso', 
                                        dimensione='$nuova_dimensione', 
                                        colore='$nuovo_colore', 
                                        volume='$nuovo_volume', 
                                        materialeUtilizzato='$nuovo_materiale_utilizzato', 
                                        quantita='$nuova_quantita', 
                                        descrizione='$nuova_descrizione', 
                                        marca='$nuova_marca', 
                                        alt='$nuovo_alt' 
                                      WHERE ID='$ID'";

                            $checkQuery = $connection->modifyDatabase($query);
                            if($checkQuery){
                                $stringaQuery = '<p class="success_Message" role="alert">Modifica del prodotto avvenuta con successo</p>';

                            }else{
                                $stringaQuery = '<p class="error_Message" role="alert">Errore durante la modifica del prodotto</p>';
                            }
                        }else{
                            //Mostra form con errori di formato
                            $stringaErrori = '<ul>';
                            foreach($err as $ers){
                            $stringaErrori .= '<li>'.$ers.'</li>';
                            }
                            $stringaErrori .= '</ul>';
 
                            $paginaHTML = str_replace("{scegliProdotto}", $scelta, $paginaHTML);
                            $paginaHTML = str_replace("{modifica}", $modifica, $paginaHTML);
                            $paginaHTML = str_replace("{selezioneCategoria}",$stringaCategoria,$paginaHTML);
                            $paginaHTML = str_replace("{selezioneMarca}",$stringaMarca,$paginaHTML); 
                            $paginaHTML = str_replace("{risultatoQuery}",$stringaErrori,$paginaHTML);   
                        } 
                        
                    }// non hai cliccato la seconda
                    $paginaHTML = str_replace("{scegliProdotto}", $scelta, $paginaHTML);
                    $paginaHTML = str_replace("{modifica}", $modifica, $paginaHTML);
                    $paginaHTML = str_replace("{selezioneCategoria}",$stringaCategoria,$paginaHTML);
                    $paginaHTML = str_replace("{selezioneMarca}",$stringaMarca,$paginaHTML); 
                    $paginaHTML = str_replace("{risultatoQuery}",$stringaQuery,$paginaHTML); 

                }else{
                    $error = DBConnectionError(true);
                    $paginaHTML = str_replace("{scegliProdotto}", $scelta, $paginaHTML);
                    $paginaHTML = str_replace("{modifica}", $error, $paginaHTML);
                }
            }else{
                $error = '<p class="error_Message" role="alert">Non ci sono attualmente prodotti nel nostro sistema</p>';
                $paginaHTML = str_replace("{scegliProdotto}", $scelta, $paginaHTML);
                $paginaHTML = str_replace("{modifica}", $error, $paginaHTML);
            }
            
        }// non hai cliccato la prima
        $paginaHTML = str_replace("{scegliProdotto}", $scelta, $paginaHTML);
        $paginaHTML = str_replace("{modifica}", $modifica, $paginaHTML);
                
    }else{
        //ridirezionamento fuori areaAdmin
       header("Location: ../index.php");
       die();
    }
/*
    $paginaHTML = str_replace("{scegliProdotto}", $scelta, $paginaHTML);
    $paginaHTML = str_replace("{modifica}", $modifica, $paginaHTML);
    $paginaHTML = str_replace("{selezioneCategoria}",$stringaCategoria,$paginaHTML);
    $paginaHTML = str_replace("{selezioneMarca}",$stringaMarca,$paginaHTML); 
    $paginaHTML = str_replace("{risultatoQuery}",$stringaErrori,$paginaHTML);  */
    
    echo $paginaHTML;

?>