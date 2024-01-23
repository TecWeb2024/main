<?php
require_once "connection.php";
use DB\DBAccess;
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

setlocale(LC_ALL, 'it_IT'); //forse mettere su tutte le pagine php

$paginaHTML = file_get_contents("indexTemplate.html");
$stringaCategorie = "";
$listaCategorie = "";
$listaBrands = "";
$stringaBrands = "";
$nomeLinkMinuscolo = "";
$nomeCategorieMinuscolo = "";

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $listaCategorie = $connection->getCategoriesFromDatabase();

    if ($listaCategorie != null) {
        $stringaCategorie = '';
        foreach ($listaCategorie as $categoria) {
            $nomeCategorieMinuscolo = strtolower(str_replace(' ', '', $categoria["nome"]));
            $stringaCategorie .= '<li><a href="' . $nomeCategorieMinuscolo . '.php"><img src="' . $categoria["immagineSfondo"] . '" alt="">' . $categoria["nome"] . '</a></li>';
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
        $stringaBrands = ''; // Inizializza la variabile $stringaBrands
        foreach ($listaBrands as $brands) {
            $nomeLinkMinuscolo = strtolower(str_replace(' ', '', $brands["nome"]));
            $stringaBrands .= '<li><a href="https://www.' . $nomeLinkMinuscolo . '.com/"><img src="' . $brands["immagineSfondo"] . '" alt="' . $brands["nome"] . '"></a></li>';
        }
    } else {
        $stringaBrands = "<li>Non sono presenti brand</li>";
    }
    
    $connection->closeDBConnection();
} else {
    $stringaBrands = "<li>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</li>";
}

$paginaHTML = str_replace("{categorie}", $stringaCategorie, $paginaHTML);
$paginaHTML = str_replace("{brands}", $stringaBrands, $paginaHTML);
echo $paginaHTML;


?>
