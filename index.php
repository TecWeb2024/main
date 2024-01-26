<?php
require_once "connection.php";
use DB\DBAccess;

setlocale(LC_ALL, 'it_IT'); //forse mettere su tutte le pagine php

$paginaHTML = file_get_contents("indexTemplate.html");
$stringaCategorie = "";
$listaCategorie = "";
$listaBrands = "";
$stringaBrands = "";
$nomeLinkMinuscolo = "";
$nomeCategorieMinuscolo = "";

$connection = new DBAccess();

if($connection->openDBConnection()) {
    
    $listaCategorie = $connection->getCategoriesFromDatabase();
    $listaBrands = $connection->getBrandsFromDatabase();
    
    $connection->closeDBConnection();

    if ($listaCategorie != null) {
        $stringaCategorie = '';
        foreach ($listaCategorie as $categoria) {
            $nomeCategorieMinuscolo = strtolower(str_replace(' ', '', $categoria["nome"]));
            $stringaCategorie .= '<li><a href="' . $nomeCategorieMinuscolo . '.php"><img src="' . $categoria["immagineSfondo"] . '" alt="">' . $categoria["nome"] . '</a></li>';
        }
    } else {
        $stringaCategorie .= "<li>Non sono presenti categorie</li>";
    }
    
    if ($listaBrands != null) {
        $stringaBrands = '';
        foreach ($listaBrands as $brands) {
            $nomeLinkMinuscolo = strtolower(str_replace(' ', '', $brands["nome"]));
            $stringaBrands .= '<li><a href="https://www.' . $nomeLinkMinuscolo . '.com/"><img src="' . $brands["immagineSfondo"] . '" alt="' . $brands["nome"] . '"></a></li>';
        }
    } else {
        $stringaBrands = "<li>Non sono presenti brand</li>";
    }

} else {
    $stringaCategorie = "<li>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</li>";
}

$paginaHTML = str_replace("{categorie}", $stringaCategorie, $paginaHTML);
$paginaHTML = str_replace("{brands}", $stringaBrands, $paginaHTML);
echo $paginaHTML;

?>
