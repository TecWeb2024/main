<?php
require_once "../connection.php";
use DB\DBAccess;

setlocale(LC_ALL, 'it_IT');
session_start();

$paginaHTML = file_get_contents("templates/faqTemplate.html");

$connection = new DBAccess();
$question = "";

if($connection->isLoggedInAdmin()){

    $paginaHTML = str_replace("{domandaUtente}", $question, $paginaHTML);
    
}else{
    //ridirezionamento fuori areaAdmin
    header("Location: ../index.php");
    die();
}

echo $paginaHTML;


?>
