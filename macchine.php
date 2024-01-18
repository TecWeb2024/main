<?php
require_once "connection.php";
use DB\DBAccess;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("macchineTemplate.html");
$stringaMacchine = "";
$listaMacchine = "";

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $listaMacchine = $connection->getMacchineFromDatabase();

    if ($listaMacchine != null) {
        foreach ($listaMacchine as $macchine) {
            $stringaMacchine .= '<li><a href="prodotto.php?id=' . $macchine["ID"] . '"><img src="' . $macchine["immagine1"] . '" alt=""><p>' . $macchine["nome"] . ' - €' . $macchine["prezzo"] . '</p></a></li>';
        }
    } else {
        $stringaMacchine .= "<li>Non sono presenti accessori</li>";
    }
    
    $connection->closeDBConnection();
} else {
    $stringaMacchine = "<li>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</li>";
}




$paginaHTML = str_replace("{macchine}", $stringaMacchine, $paginaHTML);
echo $paginaHTML;


?>