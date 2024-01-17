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


//PAGINA LOGIN controllo admin
function isLoggedIn(bool $isAdmin=false){

    if(isset($_SESSION['user'])){

        $connection = new DBAccess();

        if($connection->openDBConnection()){

            $id = $_SESSION['user'];

            $users = $connection->exec_select_query("SELECT id,admin FROM utente WHERE id=$id");

            if(count($users)>0){

                $user = $users[0];
               
                if($isAdmin){
                    return $user['admin']==1; //ritorna true se esiste ed è admin
                }else{
                    return true; //ritorna true se esiste
                }

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
public function getAdminFromDatabase($nome) {
    $admin = array();

    // Query per ottenere le categorie dalla tabella 'categoria'
    $query ="SELECT id,passw,amministratore FROM utente WHERE nome='$nome' AND amministratore=1";
    $result = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));

    if ($result && $result->num_rows > 0) {
        // Fetch dei dati e inserimento nell'array $categories
        while ($row = $result->fetch_assoc()) {
            $admin[] = $row;
        }

        // Libera la memoria del risultato
        $result->free_result();
    } else {
        // Se la query non ha prodotto risultati o ha fallito, gestisci il caso vuoto
        // Puoi impostare $categories su un valore predefinito o fare altre operazioni necessarie.
        // Ad esempio, impostare $categories su un array vuoto:
        $admin = array();
    }

    return $admin;
}







function DBConnectionError(bool $uscita = false){
    return '<p class="errorDB">I sistemi sono momentaneamente fuori servizio. Ci scusiamo per il disagio.
    Torna alla <a href="'.($uscita?'../':'').'index.php">Home</a> o riprova più tardi.</p>';
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











    public function closeDBConnection(){
        if($this->connection != null){
            mysqli_close($this->connection);
        }
    }


}
?>
