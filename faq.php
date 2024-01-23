<?php
require_once "connection.php";
use DB\DBAccess;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');
session_start();

$paginaHTML = file_get_contents("faqTemplate.html");

$question = "";

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {

    if($connection->isLoggedInUser()){
        
        $question = '
                    <label for="contenuto" class="formBig">Hai qualche domanda? Faccelo sapere qui sotto!</label>
                    <textarea name="question" id="question_Input" cols="20" rows="10" autocomplete="off"></textarea>
                    <input type="submit" name="addQuestion" value="Invia Domanda">
                    ';
    }else{
        $question = '<h2> Hai qualche domanda? Registrati sul nostro sito!</h2>';
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['addQuestion'])) {
        $domanda = $_POST['question'];
        $utenteID = $_SESSION['user'];
        $connection->saveQuestionToDatabase($domanda, $utenteID);
    }
       
    
    $connection->closeDBConnection();
} else {
    $question = "<li>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</li>";
}


$paginaHTML = str_replace("{domandaUtente}", $question, $paginaHTML);
echo $paginaHTML;


?>
