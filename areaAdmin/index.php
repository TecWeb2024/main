<?php
require_once "../connection.php";
session_start();

use DB\DBAccess;

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("templates/indexTemplate.html");
$stringaCategorie = "";
$listaCategorie = "";
$listaBrands = "";
$stringaBrands = "";
$nomeLinkMinuscolo = "";
$nomeCategorieMinuscolo = "";

$connection = new DBAccess();


if($connection->isLoggedInAdmin()){
    if($connection->openDBConnection()) {
    
        $listaCategorie = $connection->getCategoriesFromDatabase();
        $listaBrands = $connection->getBrandsFromDatabase();
        
        $connection->closeDBConnection();
    
        if ($listaCategorie != null) {
            $stringaCategorie = '';
            foreach ($listaCategorie as $categoria) {
                $nomeCategorieMinuscolo = strtolower(str_replace(' ', '', $categoria["nome"]));
                $stringaCategorie .= '<li><a href="' . $nomeCategorieMinuscolo . '.php"><img src="../' . $categoria["immagineSfondo"] . '" alt="">' . $categoria["nome"] . '</a></li>';
            }
        } else {
            $stringaCategorie .= "<li>Non sono presenti categorie</li>";
        }
        
        if ($listaBrands != null) {
            $stringaBrands = '';
            foreach ($listaBrands as $brands) {
                $nomeLinkMinuscolo = strtolower(str_replace(' ', '', $brands["nome"]));
                $stringaBrands .= '<li><a href="https://www.' . $nomeLinkMinuscolo . '.com/"><img src="../' . $brands["immagineSfondo"] . '" alt="' . $brands["nome"] . '"></a></li>';
            }
        } else {
            $stringaBrands = "<li>Non sono presenti brand</li>";
        }
        
    } else {
        $stringaCategorie .= DBConnectionError(true);
    }
 
} else {
    //ridirezionamento fuori areaAdmin
    header("Location: ../index.php");
    die();
}

$paginaHTML = str_replace("{categorie}", $stringaCategorie, $paginaHTML);
$paginaHTML = str_replace("{brands}", $stringaBrands, $paginaHTML);
echo $paginaHTML;


?>