<?php
require_once "connection.php";
use DB\DBAccess;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("accessoriTemplate.html");
$stringaAccessori = "";
$listaAccessori = "";

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $listaAccessori = $connection->getAccessoriFromDatabase();

    if ($listaAccessori != null) {
        foreach ($listaAccessori as $accessorio) {
            $stringaAccessori .= '<li><a href="prodotto.php?id=' . $accessorio["ID"] . '"><img src="' . $accessorio["immagine1"] . '" alt=""><p>' . $accessorio["nome"] . ' - €' . $accessorio["prezzo"] . '</p></a></li>';
        }
    } else {
        $stringaAccessori .= "<li>Non sono presenti accessori</li>";
    }
    
    $connection->closeDBConnection();
} else {
    $stringaAccessori = "<li>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</li>";
}




$paginaHTML = str_replace("{accessori}", $stringaAccessori, $paginaHTML);
echo $paginaHTML;


?>
