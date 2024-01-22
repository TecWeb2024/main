<?php
    require_once "connection.php";
    use DB\DBAccess;
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    setlocale(LC_ALL, 'it_IT');
    session_start();

    $paginaHTML = file_get_contents("areaAdminAggiungiProdottoTemplate.html");


    $connection = new DBAccess();
    $connectionOk = $connection->openDBConnection();

    if ($connectionOk) {

        $form = '
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br>
        
        <label for="immagine1">Immagine 1:</label>
        <input type="text" id="immagine1" name="immagine1" required><br>
        
        <label for="immagine2">Immagine 2:</label>
        <input type="text" id="immagine2" name="immagine2" required><br>
        
        <label for="immagine3">Immagine 3:</label>
        <input type="text" id="immagine3" name="immagine3" required><br>
        
        <label for="immagine4">Immagine 4:</label>
        <input type="text" id="immagine4" name="immagine4" required><br>
        
        <label for="categoria">Categoria:</label>
        <select id="categoria" name="categoria" required>
            <option value="1">Accessori</option>
            <option value="2">Macchinari</option>
            <option value="3">Pesi Liberi</option>
            <option value="4">Nutrizione</option>
        </select><br>
        
        <label for="prezzo">Prezzo:</label>
        <input type="number" id="prezzo" name="prezzo" step="0.01" required><br>
        
        <label for="peso">Peso:</label>
        <input type="text" id="peso" name="peso"><br>
        
        <label for="dimensione">Dimensione:</label>
        <input type="text" id="dimensione" name="dimensione"><br>
        
        <label for="colore">Colore:</label>
        <input type="text" id="colore" name="colore"><br>
        
        <label for="volume">Volume:</label>
        <input type="text" id="volume" name="volume"><br>
        
        <label for="materialeUtilizzato">Materiale Utilizzato:</label>
        <input type="text" id="materialeUtilizzato" name="materialeUtilizzato"><br>
        
        <label for="quantita">Quantità:</label>
        <input type="number" id="quantita" name="quantita"><br>
        
        <label for="taglia">Taglia:</label>
        <input type="text" id="taglia" name="taglia"><br>
        
        <label for="descrizione">Descrizione:</label>
        <textarea id="descrizione" name="descrizione" rows="4" required></textarea><br>
        
        <label for="tempoConsegna">Tempo di Consegna:</label>
        <textarea id="tempoConsegna" name="tempoConsegna" rows="4" required></textarea><br>

        <label for="keywords">Keywords:</label>
        <textarea id="keywords" name="keywords" rows="4" required></textarea><br>
        
        <label for="marca">Marca:</label>
        <select id="marca" name="marca" required>
            <option value="1">Optimum Nutrition</option>
            <option value="2">Cousin-Trestec</option>
            <option value="3">Technogym</option>
            <option value="4">Bodystrong Fitness</option>
            <option value="5">Adidas</option>
            <option value="6">My Protein</option>
        </select><br>
        
        <input type="submit" name="submit" value="Aggiungi Prodotto">';
        




        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) { 
            $nome = $_POST['nome'];
            $immagine1 = $_POST['immagine1'];
            $immagine2 = $_POST['immagine2'];
            $immagine3 = $_POST['immagine3'];
            $immagine4 = $_POST['immagine4'];
            $categoria = $_POST['categoria'];
            $keywords = $_POST['keywords'];
            $prezzo = $_POST['prezzo'];
            $peso = $_POST['peso'];
            $dimensione = $_POST['dimensione'];
            $colore = $_POST['colore'];
            $volume = $_POST['volume'];
            $materialeUtilizzato = $_POST['materialeUtilizzato'];
            $quantita = $_POST['quantita'];
            $taglia = $_POST['taglia'];
            $descrizione = $_POST['descrizione'];
            $tempoConsegna = $_POST['tempoConsegna'];
            $marca = $_POST['marca'];


            $successo = $connection->addProduct($nome, $immagine1, $immagine2, $immagine3, $immagine4, $categoria, $keywords, $prezzo, $peso, $dimensione, $colore, $volume, $materialeUtilizzato, $quantita, $taglia, $descrizione, $tempoConsegna, $marca);

            if ($successo) {
                echo "ok";
            } else {
                
                echo "Errore nell'inserimento del prodotto.";
            }
        }
    }
        

    $paginaHTML = str_replace("{form}", $form, $paginaHTML);
    echo $paginaHTML;
?>