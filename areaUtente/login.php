<?php
    require_once "../connection.php";
    require_once "../funzioni.php";
    session_start();

    use DB\DBAccess;
    setlocale(LC_ALL, 'it_IT');

    $paginaHTML = file_get_contents('templates/loginTemplate.html');

    $stringaLogout = "";

    if($connection->isLoggedInUser()){

        $stringaLogout .= '<p>Se vuoi disconnetterti:</p> <li><a href="logout.php" class="button">Esci</a></li>';
        $paginaHTML = str_replace("{logout}",$stringaLogout,$paginaHTML);
    
    }
    else{
        //ridirezionamento fuori areaUtente
        header("Location: ../index.php");
        die();
    }

    echo $paginaHTML;

?>
