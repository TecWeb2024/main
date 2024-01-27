<?php
    require_once "../connection.php";
    require_once "../funzioni.php";
    session_start();

    use DB\DBAccess;
    $connection = new DBAccess();

    $paginaHTML = file_get_contents('templates/registrazioneTemplate.html');

    $stringaErrori = "";
    $stringaQuery = "";

    if($connection->isLoggedInAdmin()){

        if($connection->openDBconnection()){
            if(isset($_POST['submit'])){
        
                $email = sanitizeInput($_POST['email']);
                $nome = sanitizeInput($_POST['nome']);
                $password = sanitizeInput($_POST['password']);
        
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ //forse filterinput   $email = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);
                    array_push($errori,'<p class="error_Message" role="alertdialog">Inserire una <span lang="en">email</span> valida.</p>');
                }
                if(!preg_match('/\w{3,}/',$nome)){
                    array_push($errori,'<p class="error_Message" role="alertdialog">Formato del nome non corretto</p>');
                }
        
                if(strlen($password)<4){
                    array_push($errori,'<p class="error_Message" role="alertdialog">Formato della <span lang="en">password</span> non corretto.</p>');
                }
        
                if(count($errori)==0){
                    $query="";
                    $query="INSERT INTO utente(nome, email, passw, amministratore) VALUES('$nome', '$email', '$password', 0);";
                    $checkQuery=$connection->modifyDatabase($query);
                    if($checkQuery){
                        $stringaQuery .= '<p class="success_Message" role="alertdialog">Registrazione effettuata con successo. Ora puoi effettuare il <span lang="en">login</span> dalla pagina <span lang="en">Account</span></p>';
                        $paginaHTML = str_replace("{risultatoQuery}",$stringaQuery,$paginaHTML);
                        $paginaHTML = str_replace("{erroriRegistrazione}",$DBerror,$paginaHTML);
                        
                    }else{
                        $stringaQuery .= '<p class="error_Message" role="alertdialog">Errore durante la registrazione. Le informazioni per contattarci le trovi in fondo alla pagina</p>';
                        $paginaHTML = str_replace("{risultatoQuery}",$stringaQuery,$paginaHTML);
                        $paginaHTML = str_replace("{erroriRegistrazione}",$DBerror,$paginaHTML);
                    }
                }else{
                    //Mostra form con errori di formato
                    $stringaErrori = '<ul>';
                    foreach($errori as $error){
                        $stringaErrori .= '<li>'.$error.'</li>';
                    }
                    $stringaErrori .= '</ul>';
                    
                    $paginaHTML = str_replace("{erroriRegistrazione}",$stringaErrori,$paginaHTML);
                    $paginaHTML = str_replace("{risultatoQuery}",$stringaQuery,$paginaHTML);
                    $connection->closeDBconnection();
                }
                
            }else{ //non hai inviato ancora il form
            $connection->closeDBconnection();
            $paginaHTML = str_replace("{erroriRegistrazione}",$stringaErrori,$paginaHTML);
            $paginaHTML = str_replace("{risultatoQuery}",$stringaQuery,$paginaHTML);
            }

        }else{
            $DBerror .= DBConnectionError(true);
            $paginaHTML = str_replace("{erroriRegistrazione}",$DBerror,$paginaHTML);
            $paginaHTML = str_replace("{risultatoQuery}",$stringaQuery,$paginaHTML);
        }

    }else{
        //ridirezionamento fuori areaAdmin
        header("Location: ../index.php"); 
        die();
    }   

    echo $paginaHTML;

?>