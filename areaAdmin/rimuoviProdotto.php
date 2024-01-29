<?php
    require_once "../connection.php";
    use DB\DBAccess;
   
    setlocale(LC_ALL, 'it_IT');
    session_start();

    $paginaHTML = file_get_contents("templates/rimuoviProdottoTemplate.html");
    $risultatoQuery = "";

    $connection = new DBAccess();
    
    if($connection->isLoggedInAdmin()){
        if($connection->openDBConnection()) {

        $sql = "SELECT * FROM prodotto";
        $result = $connection->customQuery($sql);
        $connection->closeDBconnection();

        $form = '<h3>Rimuovi Prodotto</h3>
                <form action="rimuoviProdotto.php" method="post">
                <label for="lista_prodotti">Seleziona il prodotto da eliminare:</label>
                <select id="lista_prodotti" name="lista_prodotti">';
                
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id_prodotto = $row['ID'];
                    $nome_prodotto = $row['nome'];
                    $form .= '<option value=' . $id_prodotto . '>' . $nome_prodotto . '</option>';
                }
                $result->free_result();
            }else{
                $form .= '<option value="0" disabled>Non ci sono prodotti</option>';
            }

        $form .= '</select><input type="submit" name="conferma" value="Conferma Scelta"></input>{risultatoQuery}</form>';

        if(isset($_POST["conferma"])) {

        $scelta_prodotto = $_POST["lista_prodotti"];
        
            if($connection->openDBConnection()){
                $query = "";
                $query = "DELETE FROM prodotto WHERE ID = $scelta_prodotto;";
                $resultQuery = $connection->modifyDatabase($query);
                $connection->closeDBconnection();

                if($resultQuery){
                    $risultatoQuery = '<p class="success_Message" role="alert">Rimozione avvenuta con successo.</p>';
                }else{
                    $risultatoQuery = '<p class="error_Message" role="alert">Fallito il tentativo di rimuovere il prodotto selezionato.</p>';
                }
            }else{
                $stringaErrori = DBConnectionError(true);
            }
        }

        $paginaHTML = str_replace("{rimuovi}",$form,$paginaHTML); 
        $paginaHTML = str_replace("{risultatoQuery}",$result,$paginaHTML);
                                              
    }else{
        $stringaErrori = DBConnectionError(true);
        $paginaHTML = str_replace("{rimuovi}",$stringaErrori,$paginaHTML); 
    }
}else{
     //ridirezionamento fuori areaAdmin
     header("Location: ../index.php");
     die();
}

    echo $paginaHTML;
?>