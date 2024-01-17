<?php
require_once "connection.php";
use DB\DBAccess;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("areaUtenteFaqTemplate.html");

$stringaFAQ = "";
$listaFAQ = "";



$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $listaFAQ = $connection->getFaqFromDatabase();
    if ($listaFAQ != null) {
        foreach ($listaFAQ as $faq) {
            $stringaFAQ .= '<li><h2>Domanda: ' . $faq["domanda"] . '</h2> <p>' . $faq["risposta"] . '</li>';
        }
    } else {
        $stringaFAQ .= "<li>Non sono presenti domande</li>";
    }
    
    $connection->closeDBConnection();
} else {
    $stringaFAQ = "<li>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</li>";
}




$paginaHTML = str_replace("{faq}", $stringaFAQ, $paginaHTML);
echo $paginaHTML;


?>
