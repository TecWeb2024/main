<?php
namespace DB;

class DBAccess {
    private const HOST_DB = "localhost";
    private const DATABASE_NAME = "tcorbu"; // Inserisci il nome del tuo database
    private const USERNAME = "tcorbu"; // Inserisci il tuo nome utente del database
    private const PASSWORD = "Ogh2uutie4IwaiCh"; // Inserisci la tua password del database

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


    public function getPeopleId($id) {
        $tuples = array();
    
        // Query per ottenere le categorie dalla tabella 'categoria'
        $query ="SELECT id,amministratore FROM utente WHERE id='$id'";
        $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));
    
        if ($result && $result->num_rows > 0) {
            // Fetch dei dati e inserimento nell'array $categories
            while ($row = $result->fetch_assoc()) {
                $tuples[] = $row;
            }
    
            // Libera la memoria del risultato
            $result->free_result();
        } else {
            // Se la query non ha prodotto risultati o ha fallito, gestisci il caso vuoto
            // Puoi impostare $categories su un valore predefinito o fare altre operazioni necessarie.
            // Ad esempio, impostare $categories su un array vuoto:
            $tuples= array();
        }
    
        return $tuples;
    }
//PAGINA LOGIN controllo se loggato e admin
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

//controllo se loggato e utente normale
function isLoggedInUser(){

    if(isset($_SESSION['user'])){

        $connection = new DBAccess();

        if($connection->openDBConnection()){

            $id = $_SESSION['user'];

            $users = $connection->getPeopleId($id);

            if(count($users)>0){

                $user = $users[0];
               
                return $user['amministratore']==0; //ritorna true se è user
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
//trovare admin nel database
public function getRowsFromDatabase($nome) {
    $people = array();

    // Query per ottenere le categorie dalla tabella 'categoria'
    $query ="SELECT id,passw,amministratore FROM utente WHERE nome='$nome'";
    $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

    if ($result && $result->num_rows > 0) {
        // Fetch dei dati e inserimento nell'array $categories
        while ($row = $result->fetch_assoc()) {
            $people[] = $row;
        }

        // Libera la memoria del risultato
        $result->free_result();
    } else {
        // Se la query non ha prodotto risultati o ha fallito, gestisci il caso vuoto
        // Puoi impostare $categories su un valore predefinito o fare altre operazioni necessarie.
        // Ad esempio, impostare $categories su un array vuoto:
        $people= array();
    }

    return $people;
}

//INSERIMENTO NEL DATABASE GENERALE, VA BENE SIA PER REGISTRAZIONE CHE PER FAQ E PRODOTTO

public function insertIntoDatabase($query) {

    $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));
    return $result;
}






//PAGINA HOME
    public function getCategoriesFromDatabase() {
        $categories = array();
    
        // Query per ottenere le categorie dalla tabella 'categoria'
        $query = "SELECT * FROM categoria";
        $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));
    
        if ($result && $result->num_rows > 0) {
            // Fetch dei dati e inserimento nell'array $categories
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
    
            // Libera la memoria del risultato
            $result->free_result();
        } else {
            // Se la query non ha prodotto risultati o ha fallito, gestisci il caso vuoto
            // Puoi impostare $categories su un valore predefinito o fare altre operazioni necessarie.
            // Ad esempio, impostare $categories su un array vuoto:
            $categories = array();
        }
    
        return $categories;
    }

    public function getBrandsFromDatabase() {
        $brands = array();
    
        // Query per ottenere le categorie dalla tabella 'Brands'
        $query = "SELECT * FROM marca";
        $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));
    
        if ($result && $result->num_rows > 0) {
            // Fetch dei dati e inserimento nell'array $brands
            while ($row = $result->fetch_assoc()) {
                $brands[] = $row;
            }
    
            // Libera la memoria del risultato
            $result->free_result();
        } else {
            // Se la query non ha prodotto risultati o ha fallito, gestisci il caso vuoto
            // Puoi impostare $brands su un valore predefinito o fare altre operazioni necessarie.
            // Ad esempio, impostare $categories su un array vuoto:
            $brands = array();
        }
    
        return $brands;
    }



//PAGINA ACCESSORI
public function getAccessoriFromDatabase() {
    $accessori = array();

    $query = "SELECT ID,nome,immagine1,prezzo FROM prodotto WHERE categoria=1";
    $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

    if ($result && $result->num_rows > 0) {
        // Fetch dei dati e inserimento nell'array $accessori
        while ($row = $result->fetch_assoc()) {
            $accessori[] = $row;
        }

        // Libera la memoria del risultato
        $result->free_result();
    } else {

        $accessori = array();
    }

    return $accessori;
}




//PAGINA PESI LIBERI
public function getPesiLiberiFromDatabase() {
    $pesiLiberi = array();

    $query = "SELECT ID,nome,immagine1,prezzo FROM prodotto WHERE categoria=2";
    $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

    if ($result && $result->num_rows > 0) {
        // Fetch dei dati e inserimento nell'array $pesiLiberi
        while ($row = $result->fetch_assoc()) {
            $pesiLiberi[] = $row;
        }

        // Libera la memoria del risultato
        $result->free_result();
    } else {

        $pesiLiberi = array();
    }

    return $pesiLiberi;
}





//PAGINA NUTRIZIONE
public function getNutrizioneFromDatabase() {
    $Nutrizione = array();

    $query = "SELECT ID,nome,immagine1,prezzo FROM prodotto WHERE categoria=3";
    $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

    if ($result && $result->num_rows > 0) {
        // Fetch dei dati e inserimento nell'array $Nutrizione
        while ($row = $result->fetch_assoc()) {
            $Nutrizione[] = $row;
        }

        // Libera la memoria del risultato
        $result->free_result();
    } else {

        $Nutrizione = array();
    }

    return $Nutrizione;
}





//PAGINA MACCHINE
public function getMacchineFromDatabase() {
    $Macchine = array();

    $query = "SELECT ID,nome,immagine1,prezzo FROM prodotto WHERE categoria=4";
    $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

    if ($result && $result->num_rows > 0) {
        // Fetch dei dati e inserimento nell'array $Macchine
        while ($row = $result->fetch_assoc()) {
            $Macchine[] = $row;
        }

        // Libera la memoria del risultato
        $result->free_result();
    } else {

        $Macchine = array();
    }

    return $Macchine;
}







//PAGINA FAQ
//variabile di input con ID dell'utente?
public function getFaqFromDataBase() {
    $domande_risposta = array();

    $query = "SELECT domanda, risposta FROM faq WHERE utente=1";//cambiare
    $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

    if ($result && $result->num_rows > 0) {
        // Fetch dei dati e inserimento nell'array $domande
        while ($row = $result->fetch_assoc()) {
            $domande_risposta[] = $row;
        }

        // Libera la memoria del risultato
        $result->free_result();
    } else {
        // Se la query non ha prodotto risultati o ha fallito, gestisci il caso vuoto
        // Puoi impostare $categories su un valore predefinito o fare altre operazioni necessarie.
        // Ad esempio, impostare $categories su un array vuoto:
        $domande_risposta = array();
    }

    return $domande_risposta;
}


//PAGINA FAQ
//salvare funzione nel DB
public function saveQuestionToDatabase($question, $userId) {
    $question = mysqli_real_escape_string($this->connection, $question);

    $query = "INSERT INTO faq (domanda, utente) VALUES ('$question', $userId)";
    
    $result = mysqli_query($this->connection, $query);

    if ($result) {
        return true;
    } else {
        echo "Errore nell'invio della domanda: " . mysqli_error($this->connection);
        return false;
    }
}





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




    public function closeDBConnection(){
        if($this->connection != null){
            mysqli_close($this->connection);
        }
    }


    /*public function exec_select_query($query){
        try {
            $res = mysqli_query($this->connection, $query);
            if (!$res) {
                throw new \Exception("Errore DB: " . mysqli_error($this->connection));
            }
    
            $resArray = array();
            
            if(mysqli_num_rows($res) > 0){
                while($row = mysqli_fetch_assoc($res)){
                    $resArray[] = $row;
                }
            }
    
            return $resArray;
        } catch (\Exception $e) {
            // Puoi gestire l'eccezione come desideri (log, mostrare messaggio, ecc.)
            // In questo esempio, verrà restituito un array vuoto in caso di errore.
            return array();
        } finally {
            if ($res) {
                $res->free();
            }
        }
    }
    
    // Esegui query che alterano il sistema
    public function exec_alter_query($query){
        try {
            $res = mysqli_query($this->connection, $query);
            if (!$res) {
                throw new \Exception("Errore DB: " . mysqli_error($this->connection));
            }
    
            return $res;
        } catch (\Exception $e) {
            // Puoi gestire l'eccezione come desideri (log, mostrare messaggio, ecc.)
            // In questo esempio, verrà restituito `false` in caso di errore.
            return false;
        }
    }*/
    
}
?>
