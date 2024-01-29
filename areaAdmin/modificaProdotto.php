<?php
    require_once "../connection.php";
    require_once "../funzioni.php";
    use DB\DBAccess;
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    setlocale(LC_ALL, 'it_IT');
    session_start();

    $paginaHTML = file_get_contents("templates/modificaProdottoTemplate.html");


    $connection = new DBAccess();
    $connectionOk = $connection->openDBConnection();

    if ($connectionOk) {
            $modifica = '';
            $sql = "SELECT * FROM prodotto";
            $result = $connection->customQuery($sql);
            $prodotto_da_modificare = NULL;

            $immagine_1_originale = '';

            $modifica .= '
                        <form method="post" enctype="multipart/form-data" class="formAdmin">
                        <h3> Modfiica un prodotto: </h3>
                        <label for="lista_prodotti_modifica">Seleziona il prodotto da modificare:</label>
                        <select id="lista_prodotti_modifica" name="lista_prodotti_modifica">';

            while ($row = $result->fetch_assoc()) {
                $id_prodotto = $row['ID'];
                $nome_prodotto = $row['nome'];
                $modifica .= '<option value=' . $id_prodotto . '>' . $nome_prodotto . '</option>';
            }

            $modifica .= '</select>
                        <button type="submit" name="conferma_modifica">Conferma Scelta</button>
                        </form>';

            

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["conferma_modifica"])) {
                $id_prodotto_modifica = $_POST["lista_prodotti_modifica"];
                $prodotto_da_modificare = $connection->getProdottoById($id_prodotto_modifica);

                // Creazione del modulo di modifica con i valori esistenti
                $modifica .= '<h3> MODIFICA PRODOTTO - ' . $prodotto_da_modificare['nome'] . '</h3>
                    <form method="post" enctype="multipart/form-data" class="formAdmin">
                    
                    <label for="id_mod">Prodotto numero:</label>
                    <input type="text" id="id_mod" name="id_mod" value="' . $prodotto_da_modificare['ID'] . '" required readonly><br>

                    <label for="nome_mod">Nome:</label>
                    <input type="text" id="nome_mod" name="nome_mod" value="' . $prodotto_da_modificare['nome'] . '" required><br>
                    
                    <label for="immagine1_mod">Immagine 1:</label>
                    <input type="file" id="immagine1_mod" name="immagine1_mod" accept="image/*">
                    <img src="' . $prodotto_da_modificare['immagine1'] . '" alt="Immagine 1 esistente" style="max-width: 100px; max-height: 100px;"  required><br>
                        
                    <label for="immagine2_mod">Immagine 2:</label>
                    <input type="file" id="immagine2_mod" name="immagine2_mod" accept="image/*">
                    <img src="' . $prodotto_da_modificare['immagine2'] . '" alt="Immagine 2 esistente" style="max-width: 100px; max-height: 100px;"><br>
                    
                    <label for="immagine3_mod">Immagine 3:</label>
                    <input type="file" id="immagine3_mod" name="immagine3_mod" accept="image/*">
                    <img src="' . $prodotto_da_modificare['immagine3'] . '" alt="Immagine 3 esistente" style="max-width: 100px; max-height: 100px;"><br>
                    
                    <label for="immagine4_mod">Immagine 4:</label>
                    <input type="file" id="immagine4_mod" name="immagine4_mod" accept="image/*">
                    <img src="' . $prodotto_da_modificare['immagine4'] . '" alt="Immagine 4 esistente" style="max-width: 100px; max-height: 100px;"><br>
                    
                    <label for="categoria_mod">Categoria:</label>
                    <select id="categoria_mod" name="categoria_mod" required>
                        <option value="1" ' . ($prodotto_da_modificare['categoria'] == 1 ? 'selected' : '') . '>Accessori</option>
                        <option value="2" ' . ($prodotto_da_modificare['categoria'] == 2 ? 'selected' : '') . '>Macchinari</option>
                        <option value="3" ' . ($prodotto_da_modificare['categoria'] == 3 ? 'selected' : '') . '>Pesi Liberi</option>
                        <option value="4" ' . ($prodotto_da_modificare['categoria'] == 4 ? 'selected' : '') . '>Nutrizione</option>
                    </select><br>
                    
                    <label for="prezzo_mod">Prezzo:</label>
                    <input type="number" id="prezzo_mod" name="prezzo_mod" step="0.01" value="' . $prodotto_da_modificare['prezzo'] . '" required><br>

                    <label for="peso_mod">Peso:</label>
                    <input type="text" id="peso_mod" name="peso_mod" value="' . $prodotto_da_modificare['peso'] . '"><br>
                                
                    <label for="dimensione_mod">Dimensione:</label>
                    <input type="text" id="dimensione_mod" name="dimensione_mod" value="' . $prodotto_da_modificare['dimensione'] . '"><br>
                                
                    <label for="colore_mod">Colore:</label>
                    <input type="text" id="colore_mod" name="colore_mod" value="' . $prodotto_da_modificare['colore'] . '"><br>
                                
                    <label for="volume_mod">Volume:</label>
                    <input type="text" id="volume_mod" name="volume_mod" value="' . $prodotto_da_modificare['volume'] . '"><br>
                                
                    <label for="materialeUtilizzato_mod">Materiale Utilizzato:</label>
                    <input type="text" id="materialeUtilizzato_mod" name="materialeUtilizzato_mod" value="' . $prodotto_da_modificare['materialeUtilizzato'] . '"><br>
                                
                    <label for="quantita_mod">Quantità:</label>
                    <input type="number" id="quantita_mod" name="quantita_mod" value="' . $prodotto_da_modificare['quantita'] . '"><br>
                                
                    <label for="taglia_mod">Taglia:</label>
                    <input type="text" id="taglia_mod" name="taglia_mod" value="' . $prodotto_da_modificare['taglia'] . '"><br>
                                
                    <label for="descrizione_mod">Descrizione:</label>
                    <textarea id="descrizione_mod" name="descrizione_mod" rows="4" required>' . $prodotto_da_modificare['descrizione'] . '</textarea><br>
                                
                    <label for="tempoConsegna_mod">Tempo di Consegna:</label>
                    <textarea id="tempoConsegna_mod" name="tempoConsegna_mod" rows="4" required>' . $prodotto_da_modificare['tempoConsegna'] . '</textarea><br>

                    <label for="keywords_mod">Keywords:</label>
                    <textarea id="keywords_mod" name="keywords_mod" rows="4" required>' . $prodotto_da_modificare['keywords'] . '</textarea><br>
                                
                    <label for="marca_mod">Marca:</label>
                    <select id="marca_mod" name="marca_mod" required>
                        <option value="1" ' . ($prodotto_da_modificare['marca'] == 1 ? 'selected' : '') . '>Optimum Nutrition</option>
                        <option value="2" ' . ($prodotto_da_modificare['marca'] == 2 ? 'selected' : '') . '>Cousin-Trestec</option>
                        <option value="3" ' . ($prodotto_da_modificare['marca'] == 3 ? 'selected' : '') . '>Technogym</option>
                        <option value="4" ' . ($prodotto_da_modificare['marca'] == 4 ? 'selected' : '') . '>Bodystrong Fitness</option>
                        <option value="5" ' . ($prodotto_da_modificare['marca'] == 5 ? 'selected' : '') . '>Adidas</option>
                        <option value="6" ' . ($prodotto_da_modificare['marca'] == 6 ? 'selected' : '') . '>My Protein</option>
                    </select><br>
                    
                    <input type="submit" name="submit_modifica" value="Salva Modifiche">
                    </form>';
            }



            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_modifica"])) { 
                $prodotto_references = $connection->getProdottoById($_POST['id_mod']);
                $connection->removeProductById($_POST['id_mod']);

                $nuovo_id = sanitizeInput($_POST['id_mod']);
                $nuovo_nome = sanitizeInput($_POST['nome_mod']);

                if (empty($_FILES['immagine1_mod']['name'])) {
                    $nuova_immagine1 = $prodotto_references['immagine1'];
                    } else {
                        $nuova_immagine1 = 'images/' . sanitizeInput(basename($_FILES['immagine1_mod']['name']));
                        move_uploaded_file(sanitizeInput($_FILES['immagine1_mod']['tmp_name']), $nuova_immagine1);
                    }

                    if (empty($_FILES['immagine2_mod']['name'])) {
                            $nuova_immagine2 = $prodotto_references['immagine2'];
                        } else {
                            $nuova_immagine2 = 'images/' . sanitizeInput(basename($_FILES['immagine2_mod']['name']));
                            move_uploaded_file(sanitizeInput($_FILES['immagine2_mod']['tmp_name']), $nuova_immagine2);
                    }

                    if (empty($_FILES['immagine3_mod']['name'])) {
                        $nuova_immagine3 = $prodotto_references['immagine3'];
                    } else {
                        $nuova_immagine3 = 'images/' . sanitizeInput(basename($_FILES['immagine3_mod']['name']));
                        move_uploaded_file(sanitizeInput($_FILES['immagine3_mod']['tmp_name']), $nuova_immagine3);
                    }

                    if (empty($_FILES['immagine4_mod']['name'])) {
                        $nuova_immagine4 = $prodotto_references['immagine4'];
                    } else {
                        $nuova_immagine4 = 'images/' . sanitizeInput(basename($_FILES['immagine4_mod'])['name']);
                        move_uploaded_file(sanitizeInput($_FILES['immagine4_mod']['tmp_name']), $nuova_immagine4);
                    }
                
                    $nuova_categoria = sanitizeInput($_POST['categoria_mod']);
                    $nuovo_prezzo = sanitizeInput($_POST['prezzo_mod']);
                    $nuovo_peso = sanitizeInput($_POST['peso_mod']);
                    $nuova_dimensione = sanitizeInput($_POST['dimensione_mod']);
                    $nuovo_colore = sanitizeInput($_POST['colore_mod']);
                    $nuovo_volume = sanitizeInput($_POST['volume_mod']);
                    $nuovo_materiale_utilizzato = sanitizeInput($_POST['materialeUtilizzato_mod']);
                    $nuova_quantita = sanitizeInput($_POST['quantita_mod']);
                    $nuova_taglia = sanitizeInput($_POST['taglia_mod']);
                    $nuova_descrizione = sanitizeInput($_POST['descrizione_mod']);
                    $nuovo_tempo_consegna = sanitizeInput($_POST['tempoConsegna_mod']);
                    $nuove_keywords = sanitizeInput($_POST['keywords_mod']);
                    $nuova_marca = sanitizeInput($_POST['marca_mod']);

                    $successo_modifica = $connection->aggiornaProdotto($nuovo_id, $nuovo_nome, $nuova_immagine1, $nuova_immagine2, $nuova_immagine3, $nuova_immagine4, $nuova_categoria, $nuove_keywords, $nuovo_prezzo, $nuovo_peso, $nuova_dimensione, $nuovo_colore, $nuovo_volume, $nuovo_materiale_utilizzato, $nuova_quantita, $nuova_taglia, $nuova_descrizione, $nuovo_tempo_consegna, $nuova_marca);

                    if ($successo_modifica) {
                        header("Location: dashboardAdmin.html");
                            exit();
                    } 
            }    
    }//CONNECTION

    //REPLACEMENT
    $paginaHTML = str_replace("{modifica}", $modifica, $paginaHTML);

    
    echo $paginaHTML;
?>