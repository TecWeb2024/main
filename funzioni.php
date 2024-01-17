<?php
/*PER ORA INUTILE TUTTO QUESTO FILE*/
use DB\DBAccess;

require_once('connection.php');

/*<?php
// Inizia la sessione
session_start();

// Verifica se il modulo di login è stato inviato
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ottieni i valori inviati dal modulo
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verifica le credenziali nel database
    // Assicurati di utilizzare pratiche sicure come l'hashing delle password
    // e di connetterti al tuo database
    // Esempio:
    $db_username = 'nome_utente_db';
    $db_password = 'password_db';
    $db_name = 'nome_database';

    $conn = new mysqli('localhost', $db_username, $db_password, $db_name);

    if ($conn->connect_error) {
        die("Connessione al database fallita: " . $conn->connect_error);
    }

    $query = "SELECT ID, nome, email, password, amministratore FROM utente WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // L'utente ha effettuato l'accesso con successo
        $row = $result->fetch_assoc();
        loginUser($row['ID'], $row['amministratore']);
        header('Location: pagina_di_benvenuto.php'); // Reindirizza l'utente alla pagina di benvenuto
        exit();
    } else {
        // Credenziali non valide
        echo "Credenziali non valide. Riprova.";
    }

    $stmt->close();
    $conn->close();
}

// Funzione per il login
function loginUser($user_id, $is_admin) {
    $_SESSION['user_id'] = $user_id;
    $_SESSION['is_admin'] = $is_admin;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
</head>
<body>

<div id="form_Container">
    <form class="form" action="#" method="post">
        <h2><span lang="en">Login</span></h2>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" class="accountButton" value="Accedi">
        <p>Non hai un <span lang="en">account</span>? <div class="account_Link"><a href="#" onclick="toggleForm()">Registrati qui</a></div></p>
    </form>
</div>

</body>
</html>
*/

return $html;


?>