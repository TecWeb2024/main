<?php
require_once "connection.php";
use DB\DBAccess;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("pesiLiberiTemplate.html");
$stringaPesiLiberi = "";
$listaPesiLiberi = "";

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $listaPesiLiberi = $connection->getPesiLiberiFromDatabase();

    if ($listaPesiLiberi != null) {
        foreach ($listaPesiLiberi as $pesiLiberi) {
            $stringaPesiLiberi .= '<li><a href="prodotto.php?id=' . $pesiLiberi["ID"] . '"><img src="' . $pesiLiberi["immagine1"] . '" alt=""><p>' . $pesiLiberi["nome"] . ' - €' . $pesiLiberi["prezzo"] . '</p></a></li>';
        }
    } else {
        $stringaPesiLiberi .= "<li>Non sono presenti pesi liberi</li>";
    }
    
    $connection->closeDBConnection();
} else {
    $stringaPesiLiberi = "<li>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</li>";
}




$paginaHTML = str_replace("{pesiLiberi}", $stringaPesiLiberi, $paginaHTML);
echo $paginaHTML;


?>
