<?php
    require_once "connection.php";
    use DB\DBAccess;
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    setlocale(LC_ALL, 'it_IT');
    session_start();

    $paginaHTML = file_get_contents("rimuoviProdottoTemplate.html");


    $connection = new DBAccess();
    $connectionOk = $connection->openDBConnection();

    if ($connectionOk) {

        $sql = "SELECT * FROM prodotto";
        $result = $connection->customQuery($sql);
        $form = '<h3> MODIFICA UN PRODOTTO </h3>
                <form method="post" enctype="multipart/form-data">
                <label for="lista_prodottia">Seleziona il prodotto da eliminare:</label>
                 <select id="lista_prodotti" name="lista_prodotti">';

        while ($row = $result->fetch_assoc()) {
            $id_prodotto = $row['ID'];
            $nome_prodotto = $row['nome'];
            $form .= '<option value=' . $id_prodotto . '>' . $nome_prodotto . '</option>';
        }

        $form .= '</select>
                <button type="submit" name="conferma">Conferma Scelta</button>
                 </form>';



    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["conferma"])) {
        $scelta_prodotto = $_POST["lista_prodotti"];
        $connection->removeProductById($scelta_prodotto);
        header("Location: dashboardAdmin.html");
        exit();
}
                                              
     
    }//CONNECTION

    //REPLACEMENT
    $paginaHTML = str_replace("{rimuovi}", $form, $paginaHTML);

    
    echo $paginaHTML;
?>