<?php
require_once "../connection.php";
use DB\DBAccess;

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("templates/faqAdminTemplate.html");

$error="";
$stringaFAQ = "";
$listaFAQ = "";

$connection = new DBAccess();

if($connection->isLoggedInAdmin()){
    
if ($connection->openDBConnection()) {
    $listaFAQ = $connection->getQuestionsFromDataBaseForAdmin();
    $connection->closeDBconnection();

    if ($listaFAQ != null) {
        foreach ($listaFAQ as $domanda) {  

            $stringaFAQ .= '<div class="box_q_a">
                            <h3 class="question"> Domanda: ' . $domanda["domanda"] . '</h3>
                            <form action="faqAdmin.php" class="form" method="get">
                            <label for="answer_">Risposta</label>
                            <input type="text" name="answer_' . $domanda["ID"] . '" id="answer_" placeholder="Scrivi qui la risposta" required>
                            <input type="hidden" name="id" value="' . $domanda["ID"] . '">
                            <input type="submit" name="submit" value="Invia risposta">
                            </form>
                            </div>';
        }
    }else{
        $stringaFAQ = '<p>Non sono presenti domande da rispondere</p>';
        $paginaHTML = str_replace("{erroriFaq}",$error,$paginaHTML);
        $paginaHTML = str_replace("{faq}",$stringaFAQ,$paginaHTML);
    }
}else{
    $error = DBConnectionError(true);
    $paginaHTML = str_replace("{erroriFaq}",$error,$paginaHTML);
    $paginaHTML = str_replace("{faq}",$stringaFAQ,$paginaHTML);
}


if(isset($_GET['submit'])){
    $idRisposta = $_GET['id'];

    $risposta = sanitizeInput($_GET['answer_' . $idRisposta . '']);
    
    if(strlen($risposta)<20){
       $error = '<p class="error_Message" role="alert">La risposta deve essere maggiore di 20 caratteri.</p>';
    }
    else{ 
        if($connection->openDBConnection()){

        $query="";
        $query = "UPDATE faq SET risposta = '$risposta' WHERE id = $idRisposta";
        $checkQuery=$connection->modifyDatabase($query);

        $connection->closeDBconnection();

        if($checkQuery){
            $error = '<p class="success_Message" role="alert">Risposta effettuata con successo.</p>';
        }else{
            $error = '<p class="error_Message" role="alert">Errore nell\'invio della risposta.</p>';
        }
        $paginaHTML = str_replace("{erroriFaq}",$error,$paginaHTML);
        $paginaHTML = str_replace("{faq}",$stringaFAQ,$paginaHTML);
        
        }else{
            $error = DBConnectionError(true);
            $paginaHTML = str_replace("{erroriFaq}",$error,$paginaHTML);
            $paginaHTML = str_replace("{faq}",$stringaFAQ,$paginaHTML);
        }
    }
}

}else{
    //ridirezionamento fuori areaAdmin
    header("Location: ../index.php");
    die();
}


echo $paginaHTML;

?>
