<?php
namespace DB;

class DBAccess {
    private const HOST_DB = "localhost";
    private const DATABASE_NAME = "mpan"; // Inserisci il nome del tuo database
    private const USERNAME = "mpan"; // Inserisci il tuo nome utente del database
    private const PASSWORD = "jih7Xooghoog7wi0"; // Inserisci la tua password del database

    private $connection;

    public function openDBConnection(){
        mysqli_report(MYSQLI_REPORT_ERROR);
        $this->connection = mysqli_connect(
            self::HOST_DB,
            self::USERNAME,
            self::PASSWORD,
            self::DATABASE_NAME
        );

        if(mysqli_connect_errno()) {
            echo "Errore di connessione al database: " . mysqli_connect_error();
            return false;
        } else {
            return true;
        }
    }

    // MODIFICA IL DATABASE
    public function modifyDatabase($query) {

        $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));
        return $result;
    }





    // PAGINA LOGIN
    public function getPeopleId($id) {
        $tuples = array();
    
        $query ="SELECT id,amministratore FROM utente WHERE id='$id'";
        $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));
    
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tuples[] = $row;
            }
    
            $result->free_result();
        } else {
            $tuples= array();
        }
        return $tuples;
    }

    function isLoggedInAdmin(){

        if(isset($_SESSION['user'])){

            $connection = new DBAccess();

            if($connection->openDBConnection()){

                $id = $_SESSION['user'];
                $users = $connection->getPeopleId($id);

                if(count($users)>0){
                    $user = $users[0];
                    return $user['amministratore']==1; //ritorna true se esiste ed è admin
                }else{
                    return false; //utente non esiste
                }
            }else{
                return false; //non è possibile collegarsi al DB
            }
        }else{
            return false; //nessuna sessione attiva
        }
    }

    function isLoggedInUser(){

        if(isset($_SESSION['user'])){

            $connection = new DBAccess();

            if($connection->openDBConnection()){

                $id = $_SESSION['user'];
                $users = $connection->getPeopleId($id);

                if(count($users)>0){
                    $user = $users[0];
                    return $user['amministratore']==0; //ritorna true se esiste ed è user
                }else{
                    return false; //utente non esiste
                }
            }else{
                return false; //non è possibile collegarsi al DB
            }
        }else{
            return false; //nessuna sessione attiva
        }

    }

    public function getRowsFromDatabase($nome) {
    $people = array();

    $query ="SELECT id,passw,amministratore FROM utente WHERE nome='$nome'";
    $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $people[] = $row;
        }
        $result->free_result();
    } else {
        $people= array();
    }
    return $people;
    }







    // PAGINA HOME
    public function getCategoriesFromDatabase() {
        $categories = array();
    
        // Query per ottenere le categorie dalla tabella 'categoria'
        $query = "SELECT * FROM categoria";
        $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));
    
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
            $result->free_result(); // Libera la memoria del risultato
        } else {
            $categories = array();
        }
        return $categories;
    }

    public function getBrandsFromDatabase() {
        $brands = array();
    
        $query = "SELECT * FROM marca";
        $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));
    
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $brands[] = $row;
            }
            $result->free_result();
        } else {
            $brands = array();
        }
        return $brands;
    }





    // PAGINA ACCESSORI
    public function getAccessoriFromDatabase() {
    $accessori = array();

    $query = "SELECT ID,nome,immagine1,prezzo,alt FROM prodotto WHERE categoria=1";
    $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $accessori[] = $row;
        }
        $result->free_result();
    } else {
        $accessori = array();
    }
    return $accessori;
    }

    //PAGINA PESI LIBERI
    public function getPesiLiberiFromDatabase() {
    $pesiLiberi = array();

    $query = "SELECT ID,nome,immagine1,prezzo,alt FROM prodotto WHERE categoria=2";
    $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pesiLiberi[] = $row;
        }
        $result->free_result();
    } else {
        $pesiLiberi = array();
    }
    return $pesiLiberi;
    }

    // PAGINA NUTRIZIONE
    public function getNutrizioneFromDatabase() {
    $nutrizione = array();

    $query = "SELECT ID,nome,immagine1,prezzo,alt FROM prodotto WHERE categoria=3";
    $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $nutrizione[] = $row;
        }
        $result->free_result();
    } else {
        $nutrizione = array();
    }
    return $nutrizione;
    }

    // PAGINA MACCHINARI
    public function getMacchinariFromDatabase() {
    $macchinari = array();

    $query = "SELECT ID,nome,immagine1,prezzo,alt FROM prodotto WHERE categoria=4";
    $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $macchinari[] = $row;
        }
        $result->free_result();
    } else {
        $macchinari = array();
    }
    return $macchinari;
    }





    //PAGINA FAQ
    public function getFaqFromDataBase() {
    $domande_risposta = array();

    $query = "SELECT domanda, risposta FROM faq WHERE utente=1";// cambiare con id utente
    $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $domande_risposta[] = $row;
        }
        $result->free_result();
    } else {
        $domande_risposta = array();
    }
    return $domande_risposta;
    }

    public function getQuestionsFromDataBaseForAdmin() {
    $domande_risposta = array();

    $query = "SELECT ID, domanda, risposta FROM faq WHERE risposta IS NULL";
    $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $domande_risposta[] = $row;
        }
        $result->free_result();
    } else {
        $domande_risposta = array();
    }
    return $domande_risposta;
    }



    



    // controllare funzione
    public function getProdottoById($idProdotto) {
    try {
        $query = "SELECT * FROM `prodotto` WHERE `ID` = ?";
        $stmt = $this->connection->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $idProdotto); // "i" indica un parametro di tipo intero
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $prodotto = $result->fetch_assoc();
                $stmt->close();
                return $prodotto;
            } else {
                $stmt->close();
                return null;
            }
        } else {
            throw new \Exception("Errore durante la preparazione della query.");
        }
    } catch (\Exception $e) {
        error_log("Errore durante il recupero del prodotto: " . $e->getMessage());
        return false;
    }
}

// esisterebbe gia un get categoria che prende *
public function getCategoriaFromId($idCategoria) {
    $query = "SELECT nome FROM categoria WHERE ID = $idCategoria";
    $result = $this->connection->query($query);

    if (!$result) {
        die("Errore nell'esecuzione della query: " . $this->connection->error);
    }

    $categoria = '';

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $categoria = $row['nome'];
    }

    $result->free_result();

    return $categoria;
}


public function saveToCart($user_Id, $product_Id, $quantity_Id) {
    // Esegue l'escape delle variabili per evitare SQL injection
    $userId = mysqli_real_escape_string($this->connection, $user_Id);
    $productId = mysqli_real_escape_string($this->connection, $product_Id);
    $quantity = mysqli_real_escape_string($this->connection, $quantity_Id);

    //verifica se il prodotto è già nel carrello
    $checkQuery = "SELECT * FROM carrello WHERE IDutente='$userId' AND IDprodotto='$productId'";
    $checkResult = mysqli_query($this->connection, $checkQuery) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

    if (mysqli_num_rows($checkResult) > 0) {
        //il prodotto è già nel carrello, aumenta la quantità
        $updateQuery = "UPDATE carrello SET quantita = quantita + '$quantity' WHERE IDutente='$userId' AND IDprodotto='$productId'";
        $updateResult = mysqli_query($this->connection, $updateQuery) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

        if ($updateResult) {
            return 1;
        } else {
            return 0;
        }
    } else {
        //il prodotto non è nel carrello
        $insertQuery = "INSERT INTO carrello (IDutente, IDprodotto, quantita) VALUES ('$userId', '$productId', '$quantity')";
        $insertResult = mysqli_query($this->connection, $insertQuery) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

        if ($insertResult) {
            return 1;
        } else {
            return 0;
        }
    }
}

public function updateProductQuantity($product_Id, $quantity) {
    // Esegue l'escape delle variabili per evitare SQL injection
    $productId = mysqli_real_escape_string($this->connection, $product_Id);
    $quantity = mysqli_real_escape_string($this->connection, $quantity);

    // Verifica se il prodotto è presente nel database
    $checkQuery = "SELECT * FROM prodotto WHERE ID='$productId'";
    $checkResult = mysqli_query($this->connection, $checkQuery) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

    if (mysqli_num_rows($checkResult) > 0) {
        $updateQuery = "UPDATE prodotto SET quantita = GREATEST(quantita - '$quantity', 0) WHERE ID='$productId'";
        $updateResult = mysqli_query($this->connection, $updateQuery) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

        if ($updateResult) {
            return 1;
        } else {
           return 0;
        }
    } else {
        return 0;
    }
}





//PAGINA ADMIN [RIMOZIONE, MODIFICA]

public function customQuery($sql, $params = []) {
    $stmt = $this->connection->prepare($sql);

    if ($stmt === false) {
        die("Errore nella preparazione della query: " . $this->connection->error);
    }

    if (!empty($params)) {
        $types = str_repeat('s', count($params)); 
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $stmt->close();

    return $result;
}

public function removeProductById($id){
    $query = 'DELETE FROM prodotto WHERE ID = ' . $id ;
    $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

    if($result){
        //echo 'operazione buon fine';
    }else{
        //echo 'errore nella rimozione del prodotto';
    }
}


public function aggiornaProdotto($nuovo_id, $nuovo_nome, $immagine1Path, $immagine2Path, $immagine3Path, $immagine4Path, $nuova_categoria, $nuove_keywords, $nuovo_prezzo, $nuovo_peso, $nuova_dimensione, $nuovo_colore, $nuovo_volume, $nuovo_materiale_utilizzato, $nuova_quantita, $nuova_taglia, $nuova_descrizione, $nuovo_tempo_consegna, $nuova_marca){
    $Query = "INSERT INTO prodotto (id, nome, immagine1, immagine2, immagine3, immagine4, categoria, keywords, prezzo, peso, dimensione, colore, volume, materialeUtilizzato, quantita, taglia, descrizione, tempoConsegna, marca) 
VALUES ('$nuovo_id', '$nuovo_nome', '$immagine1Path', '$immagine2Path', '$immagine3Path', '$immagine4Path', '$nuova_categoria', '$nuove_keywords', '$nuovo_prezzo', '$nuovo_peso', '$nuova_dimensione', '$nuovo_colore', '$nuovo_volume', '$nuovo_materiale_utilizzato', '$nuova_quantita', '$nuova_taglia', '$nuova_descrizione', '$nuovo_tempo_consegna', '$nuova_marca')";

    $result = mysqli_query($this->connection, $Query);

    if ($result) {
        //echo "Inserimento avvenuto correttamente";
        return true;
    } else {
        echo "Errore: " . mysqli_error($this->connection);
        return false;
    } 
}





    // PAGINA CARRELLO
    public function getRiepilogoFromDatabase($id) {
        $prezzo = 0;
        $quantita = 0;

        $query1 = "CREATE VIEW prezzoTotale AS
        SELECT carrello.IDprodotto AS idProdotto, prodotto.prezzo * carrello.quantita AS prezzoTotaleProdotto
        FROM carrello
        JOIN prodotto ON carrello.IDprodotto = prodotto.ID";

        $query2 = "SELECT CAST(SUM(prezzoTotale.prezzoTotaleProdotto) AS SIGNED) AS prezzoTotaleUtente
        FROM carrello
        JOIN prezzoTotale ON carrello.IDprodotto = prezzoTotale.idProdotto
        WHERE carrello.IDutente = $id
        GROUP BY carrello.IDutente";

        $query3 = "DROP VIEW prezzoTotale";
    
        $queryQuantita = "SELECT SUM(quantita) FROM carrello WHERE IDutente= $id";

        $result1 = mysqli_query($this->connection, $query1) or die("Errore nell'accesso al database" .mysqli_error($this->connection));
        $result2 = mysqli_query($this->connection, $query2) or die("Errore nell'accesso al database" .mysqli_error($this->connection));
        $result3 = mysqli_query($this->connection, $query3) or die("Errore nell'accesso al database" .mysqli_error($this->connection));
    
        $resultQuantita = mysqli_query($this->connection, $queryQuantita) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

            if ($result2 && $result2->num_rows > 0 && $resultQuantita && $resultQuantita->num_rows > 0) {
                $prezzo = $result2->fetch_assoc();
                $quantita = $resultQuantita->fetch_assoc();

                $result2->free_result();
                $resultQuantita->free_result();
            }
        return array($prezzo, $quantita);
    }
    
    public function getProdottiCarrello($id){
    $prodotti = array();

    $query = "SELECT IDprodotto,nome,prezzo,carrello.quantita,immagine1 FROM carrello,prodotto WHERE idUtente=$id AND IDprodotto=ID"; //mettere anche alt quando lo metteremo nel db
    $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $prodotti[] = $row;
        }
        $result->free_result();
    } else {
        $prodotti = array();
    }
    return $prodotti;
    }



    // CHIUDI CONNESSIONE DB
    public function closeDBConnection(){
        if($this->connection != null){
            mysqli_close($this->connection);
        }
    }
    
}
?>
