<?php
    //area admin+utente
    require_once "connection.php";
    require_once "funzioni.php";
    session_start();

    use DB\DBAccess;
    $connection = new DBAccess();
    $paginaHTML     = file_get_contents('loginTemplate.html'); //login.html


    $stringaErrori = "";
    $stringaLogout = "";
    $DBerror = "";

    if($connection->isLoggedInAdmin()){

        $stringaLogout .= '<p>Se vuoi disconnetterti:</p> <li><a href="logout.php" class="button">Esci</a></li>';
       /* if(isset($_POST['logout']))
        {
            session_unset();

        //Redirect al login
        header("Location: index.php");
        }*/
        $paginaHTML = str_replace("{errori}",$stringaErrori,$paginaHTML);
        $paginaHTML = str_replace("{logout}",$stringaLogout,$paginaHTML);
        //die();

    }
    elseif($connection->isLoggedInUser()){

        $stringaLogout .= '<p>Se vuoi disconnetterti:</p> <li><a href="logout.php" class="button">Esci</a></li>';
       /* if(isset($_POST['logout']))
        {
            session_unset();

        //Redirect al login
        header("Location: index.php");
        }*/
        $paginaHTML = str_replace("{errori}",$stringaErrori,$paginaHTML);
        $paginaHTML = str_replace("{logout}",$stringaLogout,$paginaHTML);
        //die();

    }
    else{ //se non è ancora loggato,non puoi passare d aun'account all'altro senza sloggarti. SOLUZIONE: togliere gli else
        if(isset($_POST['submit'])){
            //Invio del form

            $errori = [];

            $nome = sanitizeInput($_POST['nome']);
            $password = sanitizeInput($_POST['password']);


            if(!preg_match('/\w{3,}/',$nome)){
                array_push($errori,'<p class="error_Message">Formato del nome non corretto</p>');
            }

            if(strlen($password)<4){
                array_push($errori,'<p class="error_Message">Formato della <span lang="en">password</span> non corretto.</p>');
            }

            if(count($errori)==0){

                if($connection->openDBconnection()){
                    
                    //Cerca admin con quell'id
                    $users = $connection->getRowsFromDatabase($nome);  
                    $connection->closeDBconnection();

                    if(count($users)>0){ //esistono persone
                       
                        $user = $users[0];
                        if($user['amministratore']==1)
                        {
                            if($password==$user['passw']){ //password_verify($password,$user['passw'])

                                $_SESSION['user'] = $user['id'];
    
                                header("Location: faq.html");
                                die();
    
                            }else{ //era role="alert" dentro il tag, password errata
                                array_push($errori,'<p class="error_Message">Nome o <span lang="en">password</span> non corretti</p>');
                            }
                        }
                        elseif($user['amministratore']==0)
                        {
                            if($password==$user['passw']){ //password_verify($password,$user['passw'])

                                $_SESSION['user'] = $user['id'];
    
                                header("Location: index.php");
                                die();
    
                            }else{ //era role="alert" dentro il tag, password errata
                                array_push($errori,'<p class="error_Message">Nome o <span lang="en">password</span> non corretti</p>');
                            }
                        }

                    }else{//persona non trovata
                        array_push($errori,'<p class="error_Message">2Nome o <span lang="en">password</span> non corretti</p>');
                    }

                    $stringaErrori = '<ul>';
                    foreach($errori as $error){
                        $stringaErrori .= '<li>'.$error.'</li>';
                    }
                    $stringaErrori .= '</ul>';
                    $paginaHTML = str_replace("{errori}",$stringaErrori,$paginaHTML); //Contiene solo l'ultimo errore
                    $paginaHTML = str_replace("{logout}",$stringaLogout,$paginaHTML);
                }else{ //non è stato possibile aprire una connessione al database
                    $DBerror .= DBConnectionError(true);
                    $paginaHTML = str_replace("{errori}",$DBerror,$paginaHTML);
                    $paginaHTML = str_replace("{logout}",$stringaLogout,$paginaHTML);
                }                       
            }else{ //ci sono errori
                 //Mostra form con errori di formato
                $stringaErrori = '<ul>';
                foreach($errori as $error){
                    $stringaErrori .= '<li>'.$error.'</li>';
                }
                $stringaErrori .= '</ul>'; //prima era '<ul>'
                $paginaHTML = str_replace("{errori}",$stringaErrori,$paginaHTML);
                $paginaHTML = str_replace("{logout}",$stringaLogout,$paginaHTML);
            }
        }else{ //non hai inviato ancora il form
            $paginaHTML = str_replace("{errori}",$stringaErrori,$paginaHTML);
            $paginaHTML = str_replace("{logout}",$stringaLogout,$paginaHTML);
        } 
    }


    echo $paginaHTML;

?>