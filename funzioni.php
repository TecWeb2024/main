<?php

use DB\DBAccess;

require_once('connection.php');


function replace_in_page(String $html, String $title, String $id){


$html = str_replace("{categorie}", $stringaCategorie, $paginaHTML);
$html = str_replace("{brands}", $stringaBrands, $paginaHTML);


return $html;
}

?>