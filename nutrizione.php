<?php
require_once "connection.php";
use DB\DBAccess;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("nutrizioneTemplate.html");
$stringaNutrizione = "";
$listaNutrizione = "";

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $listaNutrizione = $connection->getNutrizioneFromDatabase();

    if ($listaNutrizione != null) {
        foreach ($listaNutrizione as $Nutrizione) {
            $stringaNutrizione .= '<li><a href="' . $Nutrizione["nome"] . '.html"><img src="' . $Nutrizione["immagine1"] . '" alt=""><p>' . $Nutrizione["nome"] . ' - €' . $Nutrizione["prezzo"] . '</p></a></li>';
        }
    } else {
        $stringaNutrizione .= "<li>Non sono presenti alimentari</li>";
    }
    
    $connection->closeDBConnection();
} else {
    $stringaNutrizione = "<li>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</li>";
}




$paginaHTML = str_replace("{nutrizione}", $stringaNutrizione, $paginaHTML);
echo $paginaHTML;


?>
