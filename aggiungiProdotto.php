<?php
    require_once "connection.php";
    use DB\DBAccess;
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    setlocale(LC_ALL, 'it_IT');
    session_start();

    $paginaHTML = file_get_contents("aggiungiProdottoTemplate.html");


    $connection = new DBAccess();
    $connectionOk = $connection->openDBConnection();

    if ($connectionOk) {
                            
                            
                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) { 
                                $nome = $_POST['nome'];
                                $immagine1 = $_FILES['immagine1']['name'];
                                $immagine2 = $_FILES['immagine2']['name'];
                                $immagine3 = $_FILES['immagine3']['name'];
                                $immagine4 = $_FILES['immagine4']['name'];
                                $categoria = $_POST['categoria'];
                                $keywords = $_POST['keywords'];
                                $prezzo = $_POST['prezzo'];
                                $peso = $_POST['peso'];
                                $dimensione = $_POST['dimensione'];
                                $colore = $_POST['colore'];
                                $volume = $_POST['volume'];
                                $materialeUtilizzato = $_POST['materialeUtilizzato'];
                                $quantita = $_POST['quantita'];
                                $taglia = $_POST['taglia'];
                                $descrizione = $_POST['descrizione'];
                                $tempoConsegna = $_POST['tempoConsegna'];
                                $marca = $_POST['marca'];

                                $uploadDirectory = 'images/';
                                $immagine1FileName = uniqid() . '_' . $immagine1;
                                $immagine2FileName = uniqid() . '_' . $immagine2;
                                $immagine3FileName = uniqid() . '_' . $immagine3;
                                $immagine4FileName = uniqid() . '_' . $immagine4;

                                $immagine1Path = $uploadDirectory . basename($immagine1FileName);
                                $immagine2Path = $uploadDirectory . basename($immagine2FileName);
                                $immagine3Path = $uploadDirectory . basename($immagine3FileName);
                                $immagine4Path = $uploadDirectory . basename($immagine4FileName);

                                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                                $fileExtension1 = strtolower(pathinfo($immagine1FileName, PATHINFO_EXTENSION));
                                $fileExtension2 = strtolower(pathinfo($immagine2FileName, PATHINFO_EXTENSION));
                                $fileExtension3 = strtolower(pathinfo($immagine3FileName, PATHINFO_EXTENSION));
                                $fileExtension4 = strtolower(pathinfo($immagine4FileName, PATHINFO_EXTENSION));

                                if (in_array($fileExtension1, $allowedExtensions) &&
                                    in_array($fileExtension2, $allowedExtensions) &&
                                    in_array($fileExtension3, $allowedExtensions) &&
                                    in_array($fileExtension4, $allowedExtensions)) {
                                    // Sposta le immagini nella cartella images
                                    move_uploaded_file($_FILES['immagine1']['tmp_name'], $immagine1Path);
                                    move_uploaded_file($_FILES['immagine2']['tmp_name'], $immagine2Path);
                                    move_uploaded_file($_FILES['immagine3']['tmp_name'], $immagine3Path);
                                    move_uploaded_file($_FILES['immagine4']['tmp_name'], $immagine4Path);
                                }

                                $successo = $connection->addProduct($nome, $immagine1Path, $immagine2Path, $immagine3Path, $immagine4Path, $categoria, $keywords, $prezzo, $peso, $dimensione, $colore, $volume, $materialeUtilizzato, $quantita, $taglia, $descrizione, $tempoConsegna, $marca);
                        
                                if ($successo) {
                                    header("Location: dashboardAdmin.html");
                                    exit();
                                } else {
                                    
                                    //echo "Errore nell'inserimento del prodotto.";
                                }
                            }         
    }//CONNECTION

    //REPLACEMENT


    
    echo $paginaHTML;
?>