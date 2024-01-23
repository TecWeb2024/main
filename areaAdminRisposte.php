<?php
require_once "connection.php";
use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("areaUtenteFaqTemplate.html");

$stringaFAQ = "";
$listaFAQ = "";

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $listaFAQ = $connection->getQuestionsFromDataBaseForAdmin();

    if ($listaFAQ != null) {
        foreach ($listaFAQ as $faq) {

                $stringaFAQ .= '<div class="box_q_a">
                                    <h3 class="question"> Domanda: ' . $faq["domanda"] . '</h3>
                                    <form method="post">
                                        <input type="hidden" name="question_id" value="' . $faq["id_domanda"] . '">
                                        <input type="text" name="answer" placeholder="Scrivi qui la risposta" required>
                                        <input type="submit" name="submit_' . $faq["id_domanda"] . '" value="Invia risposta">
                                    </form>';

        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            foreach ($listaFAQ as $faq) {
                // Verifica se il pulsante specifico è stato premuto
                if (isset($faq["id_domanda"]) && isset($_POST["submit_" . $faq["id_domanda"]])) {
                    $question_id = $_POST["question_id"];
                    $answer = $_POST["answer"];
                    
                    $connection->saveRisposta($answer, $question_id);
                    break;
                }
            }
        }
    }

    $paginaHTML = str_replace("{faq}", $stringaFAQ, $paginaHTML);
    echo $paginaHTML;
}
?>
