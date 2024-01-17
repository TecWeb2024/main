<?php
    //area admin
    require_once "connection.php";
    require_once "funzioni.php";
    session_start();

    use DB\DBAccess;

    $paginaHTML     = file_get_contents('accountTemplate.html'); //login.html


    $stringaErrori = "";

    if(false){ //isLoggedIn(true)

        //header("Location: index.php");
        //die();

    }else{ //se non è ancora loggato

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
                $connection = new DBAccess();
                if($connection->openDBconnection()){
                    
                    //Cerca admin con quell'id
                    $users = $connection->getAdminFromDatabase($nome);  
                    $connection->closeDBconnection();

                    if(count($users)>0){ //admin trovato
                       
                        $user = $users[0];

                        if($password==$user['passw']){ //password_verify($password,$user['passw'])

                            $_SESSION['user'] = $user['id'];

                            header("Location: index.php");
                            die();

                        }else{ //era role="alert" dentro il tag, password errata
                            array_push($errori,'<p class="error_Message">1Nome o <span lang="en">password</span> non corretti</p>');
                            echo "Password immessa: " . $password;
                            echo "Hash nel database: " . $user['passw'];
                        }

                    }else{//admin non trovato
                        array_push($errori,'<p class="error_Message">2Nome o <span lang="en">password</span> non corretti</p>');
                    }

                    $stringaErrori = '<ul>';
                    foreach($errori as $error){
                        $stringaErrori .= '<li>'.$error.'</li>';
                    }
                    $stringaErrori .= '</ul>';
                    $paginaHTML = str_replace("{errori}",$stringaErrori,$paginaHTML); //Contiene solo l'ultimo errore
                }else{ //non è stato possibile aprire una connessione al database
                    $DBerror .= DBConnectionError(true);
                    $paginaHTML = str_replace("{errori}",$DBerror,$paginaHTML);
                }                       
            }else{ //ci sono errori
                 //Mostra form con errori di formato
                $stringaErrori = '<ul>';
                foreach($errori as $error){
                    $stringaErrori .= '<li>'.$error.'</li>';
                }
                $stringaErrori .= '</ul>'; //prima era '<ul>'
                $paginaHTML = str_replace("{errori}",$stringaErrori,$paginaHTML);
            }
        }else{ //non hai inviato ancora il form
            $paginaHTML = str_replace("{errori}",$stringaErrori,$paginaHTML);
        } 
    }

    //$template = str_replace('{{content}}',$DBerror,$template);

    echo $paginaHTML;

?>