<?php
namespace DB;

class DBAccess {
    private const HOST_DB = "localhost";
    private const DATABASE_NAME = "fpivetta"; // Inserisci il nome del tuo database
    private const USERNAME = "fpivetta"; // Inserisci il tuo nome utente del database
    private const PASSWORD = "iecog8Eiqu9utupi"; // Inserisci la tua password del database

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




    public function getCategoriesFromDatabase() {
        $categories = array();
    
        // Query per ottenere le categorie dalla tabella 'categoria'
        $query = "SELECT * FROM categoria";
        $queryResult = mysqli_query($this->connection, $query) or die("Errore nell'accesso al database" .mysqli_error($this->connection));
    
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
    

    public function closeConnection(){
        if($this->connection != null){
            mysqli_close($this->connection);
        }
    }
}
?>