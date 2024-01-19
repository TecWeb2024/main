<?php
    //area admin+utente
    require_once "connection.php";
    require_once "funzioni.php";
    session_start();

    use DB\DBAccess;
    $connection = new DBAccess();
    $connectionOk = $connection->openDBConnection();
    $paginaHTML     = file_get_contents('registrazioneTemplate.html'); //login.html


    $stringaErrori = "";
    $stringaQuery = "";
    $DBerror = "";
    $errori = [];



    if($connection->isLoggedInAdmin()){

        $stringaErrori .= '<p>Sei già registrato come amministratore nel sistema</p>';
        $paginaHTML = str_replace("{erroriRegistrazione}",$stringaErrori,$paginaHTML);
        $paginaHTML = str_replace("{risultatoQuery}",$stringaQuery,$paginaHTML);
    }
    elseif($connection->isLoggedInUser()){

        $stringaErrori .= '<p>Sei già registrato come utente nel sistema</p>';
        $paginaHTML = str_replace("{erroriRegistrazione}",$stringaErrori,$paginaHTML);
        $paginaHTML = str_replace("{risultatoQuery}",$stringaQuery,$paginaHTML);
    }
    else{
        
        $connection = new DBAccess();
                if($connection->openDBconnection()){
                    if(isset($_POST['submit'])){
                        //Invio del form
                
                        
                
                        $email = sanitizeInput($_POST['email']);
                        $nome = sanitizeInput($_POST['nome']);
                        $password = sanitizeInput($_POST['password']);
                
                
                        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ //forse filterinput   $email = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);
                            array_push($errori,'<p class="error_Message">Inserire una <span lang="en">email</span> valida.</p>');
                        }
                        if(!preg_match('/\w{3,}/',$nome)){
                            array_push($errori,'<p class="error_Message">Formato del nome non corretto</p>');
                        }
                
                        if(strlen($password)<4){
                            array_push($errori,'<p class="error_Message">Formato della <span lang="en">password</span> non corretto.</p>');
                        }
                
                        if(count($errori)==0){
                            $query="";
                            $query="INSERT INTO utente(nome, email, passw, amministratore) VALUES('$nome', '$email', '$password', 0);";
                            $checkQuery=$connection->insertIntoDatabase($query);
                            if($checkQuery){
                                $stringaQuery .= '<p class="success_Message">Registrazione effettuata con successo. Ora puoi accedere dalla pagina di <span lang="en">Login</span></p>';
                                $paginaHTML = str_replace("{risultatoQuery}",$stringaQuery,$paginaHTML);
                                $paginaHTML = str_replace("{erroriRegistrazione}",$DBerror,$paginaHTML);
                            }else{
                                $stringaQuery .= '<p class="error_Message">Errore durante la registrazione. Le informazioni per contattarci le trovi in fondo alla pagina</p>';
                                $paginaHTML = str_replace("{risultatoQuery}",$stringaQuery,$paginaHTML);
                                $paginaHTML = str_replace("{erroriRegistrazione}",$DBerror,$paginaHTML);
                            }
                        }else{
                             //Mostra form con errori di formato
                            $stringaErrori = '<ul>';
                            foreach($errori as $error){
                                $stringaErrori .= '<li>'.$error.'</li>';
                            }
                            $stringaErrori .= '</ul>'; //prima era '<ul>'
                            $paginaHTML = str_replace("{erroriRegistrazione}",$stringaErrori,$paginaHTML);
                            $paginaHTML = str_replace("{risultatoQuery}",$stringaQuery,$paginaHTML);
                        }
                        
                    }else{ //non hai inviato ancora il form
                    $paginaHTML = str_replace("{erroriRegistrazione}",$stringaErrori,$paginaHTML);
                    $paginaHTML = str_replace("{risultatoQuery}",$stringaQuery,$paginaHTML);
                    }
                }else{
                    $DBerror .= DBConnectionError(true);
                    $paginaHTML = str_replace("{erroriRegistrazione}",$DBerror,$paginaHTML);
                    $paginaHTML = str_replace("{risultatoQuery}",$stringaQuery,$paginaHTML);
                }


        
    }   

    

    echo $paginaHTML;

?>