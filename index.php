<?php
// Connessione al database (sostituisci con i tuoi dettagli di connessione)
require_once "connection.php";
use DB\DBAccess;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("indexTemplate.html");
$stringaCategorie = "";
$listaCategorie = "";
$listaBrands = "";
$stringaBrands = "";
$nomeLinkMinuscolo = "";

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $listaCategorie = $connection->getCategoriesFromDatabase();

    if ($listaCategorie != null) {
        foreach ($listaCategorie as $categoria) {
            $stringaCategorie .= '<li><a href="' . $categoria["nome"] . '.html"><img src="' . $categoria["immagineSfondo"] . '" alt="">' . $categoria["nome"] . '</a></li>';
        }
    } else {
        $stringaCategorie .= "<li>Non sono presenti categorie</li>";
    }
    
    $connection->closeDBConnection();
} else {
    $stringaCategorie = "<li>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</li>";
}



//$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $listaBrands = $connection->getBrandsFromDatabase();
    
    if ($listaBrands != null) {
        foreach ($listaBrands as $brands) {
            $nomeLinkMinuscolo .= strtolower(str_replace(' ', '', $brands["nome"]));
            $stringaBrands .= '<li><a href="' . $nomeLinkMinuscolo . '.html"><img src="' . $brands["immagineSfondo"] . '" alt="' . $brands["nome"] . '"></a></li>';
        }
    } else {
        $stringaBrands .= "<li>Non sono presenti brand</li>";
    }

    $connection->closeDBConnection();
} else {
    $stringaBrands = "<li>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</li>";
}

$paginaHTML = str_replace("{categorie}", $stringaCategorie, $paginaHTML);
$paginaHTML = str_replace("{brands}", $stringaBrands, $paginaHTML);
echo $paginaHTML;


?>
