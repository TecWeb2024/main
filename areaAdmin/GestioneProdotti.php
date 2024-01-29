<?php
    require_once "../connection.php";
    require_once "../funzioni.php";

    use DB\DBAccess;

    setlocale(LC_ALL, 'it_IT');
    session_start();

    $paginaHTML = file_get_contents("templates/GestioneProdottiTemplate.html");

    $connection = new DBAccess();
    $stringaErrori = "";
    $stringaQuery = "";
    $err = [];
    
    $listaCategoria = "";
    $stringaCategoria = "";

    if($connection->isLoggedInAdmin()){

        if($connection->openDBConnection()){

            $listaCategoria = $connection->getCategoriesFromDatabase();
            $connection->closeDBConnection();
        
            if ($listaAccessori != null) {
                foreach ($listaCategoria as $categoria) {
                    $stringaCategoria .= '';
                }
            } else {
                $stringaCategoria = "<option value="0" disabled>Non sono presenti categorie</option>";
            }
        $connection->closeDBconnection();

        }else{
            $stringaErrori = DBConnectionError(true);
        }
        <option value="1">Accessori</option>
        {selezioneCategoria}

        if(isset($_POST["submit"])){

            $nome = sanitizeInput($_POST['nome']);
            $immagine1 = sanitizeInput($_FILES['immagine1']['name']);
            $immagine2 = sanitizeInput($_FILES['immagine2']['name']);
            $immagine3 = sanitizeInput($_FILES['immagine3']['name']);
            $immagine4 = sanitizeInput($_FILES['immagine4']['name']);

            $categoria = sanitizeInput($_POST['categoria']);

            $keywords = sanitizeInput($_POST['keywords']);
            $prezzo = sanitizeInput($_POST['prezzo']);
            $peso = sanitizeInput($_POST['peso']);
            $dimensione = sanitizeInput($_POST['dimensione']);
            $colore = sanitizeInput($_POST['colore']);
            $volume = sanitizeInput($_POST['volume']);
            $materialeUtilizzato = sanitizeInput($_POST['materialeUtilizzato']);
            $quantita = sanitizeInput($_POST['quantita']);
            $descrizione = sanitizeInput($_POST['descrizione']);
            $marca = sanitizeInput($_POST['marca']);
            $alt = sanitizeInput($_POST['alt']);

            $uploadDirectory = '../images/';
            $immagine1FileName = uniqid() . '_' . $immagine1;
            $immagine2FileName = uniqid() . '_' . $immagine2;
            $immagine3FileName = uniqid() . '_' . $immagine3;
            $immagine4FileName = uniqid() . '_' . $immagine4;

            $immagine1Path = $uploadDirectory . basename($immagine1FileName);
            $immagine2Path = $uploadDirectory . basename($immagine2FileName);
            $immagine3Path = $uploadDirectory . basename($immagine3FileName);
            $immagine4Path = $uploadDirectory . basename($immagine4FileName);

            $allowedExtensions = ['jpg', 'jpeg', 'png'];
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

            $maxSize = 1024 * 1024;
            
            $fileSize1 = $_FILES['immagine1']['size'];
         
            $fileSize2 = $_FILES['immagine2']['size'];

            $fileSize3 = $_FILES['immagine3']['size'];

            $fileSize4 = $_FILES['immagine4']['size'];
            
            
            if(!preg_match('/\w{3,}/',$nome)){ 
                array_push($err,'<p class="error_Message" role="alert">Nome del prodotto deve essere maggiore di 3 lettere.</p>');
            }
            if($fileSize1 > $maxSize){
                array_push($err,'<p class="error_Message" role="alert">Immagine 1 deve essere inferiore ad un <span>megabyte</span>.</p>');
            }
            if($fileSize2 > $maxSize){
                array_push($err,'<p class="error_Message" role="alert">Immagine 2 deve essere inferiore ad un <span>megabyte</span>.</p>');
            }
            if($fileSize3 > $maxSize){ 
                array_push($err,'<p class="error_Message" role="alert">Immagine 3 deve essere inferiore ad un <span>megabyte</span>.</p>');
            }
            if($fileSize4 > $maxSize){ 
                array_push($err,'<p class="error_Message" role="alert">Immagine 4 deve essere inferiore ad un <span>megabyte</span>.</p>');
            }
            if(){ 
                array_push($err,'<p class="error_Message" role="alert">.</p>');
            }
            if(){ 
                array_push($err,'<p class="error_Message" role="alert">.</p>');
            }
        
            if(count($err)==0){

            if($connection->openDBConnection()){

                $query = "";
                $query = "INSERT INTO prodotto(nome, immagine1, immagine2, immagine3, immagine4, categoria, keywords, prezzo, peso, dimensione, colore, volume, materialeUtilizzato, quantita, descrizione, marca, alt) VALUES ('$nome', '$immagine1', '$immagine2', '$immagine3', '$immagine4', '$categoria', '$keywords', '$prezzo', '$peso', '$dimensione', '$colore', '$volume', '$materialeUtilizzato', '$quantita', '$descrizione', '$marca', '$alt')";
    
                $checkQuery = $connection->modifyDatabase($nome, $immagine1Path, $immagine2Path, $immagine3Path, $immagine4Path, $categoria, $keywords, $prezzo, $peso, $dimensione, $colore, $volume, $materialeUtilizzato, $quantita, $descrizione, $marca, $alt);
                $connection->closeDBconnection();

                    if($checkQuery) {
                        $stringaQuery = '<p class="succes_Message" role="alert">Il prodotto è stato correttamente aggiungo al <span lang="en">database</span>.</p>';
                    }else{
                        $stringaQuery = '<p class="error_Message" role="alert">Non è stato possibile aggiungere il prodotto al <span lang="en">database</span>, se l\'errore sussiste si rivolga all\'assistenza.</p>';
                    }
            }else{
                $stringaErrori = DBConnectionError(true);
                $paginaHTML = str_replace("{errori}",$stringaErrori,$paginaHTML);
                $paginaHTML = str_replace("{risultatoQuery}",$stringaQuery,$paginaHTML);
            }

            }else{
            //Mostra form con errori di formato
            $stringaErrori = '<ul>';
                foreach($errori as $error){
                    $stringaErrori .= '<li>'.$error.'</li>';
                }
            $stringaErrori .= '</ul>';

            $paginaHTML = str_replace("{errori}",$stringaErrori,$paginaHTML);
            $paginaHTML = str_replace("{risultatoQuery}",$stringaQuery,$paginaHTML);
            }  
        } // non hai premuto
        $paginaHTML = str_replace("{errori}",$stringaErrori,$paginaHTML);  
        $paginaHTML = str_replace("{risultatoQuery}",$stringaQuery,$paginaHTML);      

    }else{
        //ridirezionamento fuori areaAdmin
        header("Location: ../index.php");
        die();
    }

    echo $paginaHTML;
?>