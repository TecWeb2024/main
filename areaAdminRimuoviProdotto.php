<?php
    require_once "connection.php";
    use DB\DBAccess;
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    setlocale(LC_ALL, 'it_IT');

    $paginaHTML = file_get_contents("areaAdminRimuoviProdottoTemplate.html");


    $connection = new DBAccess();
    $connectionOk = $connection->openDBConnection();
    $lista_prodotti = '';

    if ($connectionOk) {
        $sql = "SELECT ID, nome FROM prodotto";
        $result = $connection->customQuery($sql);  
        
        while ($row = $result->fetch_assoc()) {
            $id_prodotto = $row['ID'];
            $nome_prodotto = $row['nome'];
            $lista_prodotti .=  '<option value= ' . $id_prodotto . ' > ' . $nome_prodotto . '</option>';
        }
        
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["conferma_scelta"])) {
        $scelta_prodotto = $_POST["lista_prodotti"];
        $connection->removeProductById($scelta_prodotto);
    }

    $paginaHTML = str_replace("{lista_prodotti}", $lista_prodotti, $paginaHTML);
    echo $paginaHTML;
?>