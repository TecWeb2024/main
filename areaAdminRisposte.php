<?php
require_once "connection.php";
use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("areaAdminRisposteTemplate.html");



$stringaFAQ = "";
$listaFAQ = "";

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $listaFAQ = $connection->getQuestionsFromDataBaseForAdmin();
 
    if ($listaFAQ != null) {
        foreach ($listaFAQ as $domanda) {  

            $stringaFAQ .= '<div class="box_q_a">
                            <h3 class="question"> Domanda: ' . $domanda["domanda"] . '</h3>
                            <form method="post">
                            <input type="hidden" name="question_id_' . $domanda["ID"] . '" value="' . $domanda["ID"] . '">
                            <input type="text" name="answer_' . $domanda["ID"] . '" placeholder="Scrivi qui la risposta" required>
                            <input type="submit" name="submit_' . $domanda["ID"] . '" value="Invia risposta">
                            </form>
                            </div>';
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        foreach ($listaFAQ as $domanda) {
            $submitKey = "submit_" . $domanda["ID"];
            if (array_key_exists($submitKey, $_POST) && $_POST[$submitKey] !== null) {
                $question_id = $_POST["question_id_" . $domanda["ID"]];
                $answer = $_POST["answer_" . $domanda["ID"]];
   
                $connection->saveRisposta($answer, $question_id);
            } else {
                    
            }
        }
    }
    
    





}//CONNECTIONOK

$paginaHTML = str_replace("{faq}", $stringaFAQ, $paginaHTML);
echo $paginaHTML;
