<?php
if(!isset($_SESSION)){
    session_start();
}
require_once(__DIR__ . "/autoLoader.php");
require_once(__DIR__ . "/function.php");
//print_r( $_SESSION['teammates']);
$pristup_zakazan = true;
$role = 'null';
//print_r(time() - $_SESSION['aktivita']);
//echo "<br>";
function overUzivatele($pristup_zakazan)
{

    if ($pristup_zakazan == TRUE) {
        $error = urlencode("Vyžadováno přihlášení k zobrazení, přihlašte se výše.");
        header("Location:/logOut.php?errorUser=$error");
        die("Vyzadovano prihlaseni, opakuj akci po prihlaseni - probiha presmerovani");
    }

}

function overovaniRelace()
{
    require_once(__DIR__ . "/function.php");
    require_once __DIR__ . "/autoLoader.php";
    $dbh = new DatabaseConnector();
    $dbh = $dbh->getDbLink();
    if ($_SESSION['agent'] == sha1($_SERVER['HTTP_USER_AGENT'])) {

        $stmt = $dbh->prepare("SELECT username, ipAddress, agent FROM logins WHERE username = :username 
                          AND idLogin = (SELECT MAX(idLogin) FROM logins WHERE username = :username )");
        $stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
        $stmt->execute();
        $vysledek = $stmt->fetch();
        if (sha1($_SERVER['HTTP_USER_AGENT']) == $vysledek['agent'] ) {
            session_regenerate_id();
            session_regenerate_id(true);
            setSessionTeammates(getTeammates($_SESSION['username']));
            $_SESSION['aktivita'] = time(); //aktualizace pro posledni akci
            return TRUE;
        } else {
            $vysledek = "Informace uživatele se neshodují s daty v databázi! Ukončuji relaci!";
            zapis_log_login($_SESSION['username'], $vysledek, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
            return FALSE;
        }
    } else {
        $vysledek = "Informace uživatele se neshodují s daty v relaci uživatele! Ukončuji relaci!";
        zapis_log_login($_SESSION['username'], $vysledek, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
        return FALSE;
    }
}


if (!isset($_SESSION['jmeno']) OR !isset($_SESSION['agent'])) {
    $chyba = 'Pro přístup k této stránce je vyžadováno PŘIHLÁŠENÍ!';
    $pristup_zakazan = true;
}

if (isset($_SESSION['aktivita']) && (time() - $_SESSION['aktivita'] > 3600)) {
    $vysledek = "Dlouho neaktivni,time:".time()."session:".$_SESSION['aktivita'];
    zapis_log_login($_SESSION['username'], $vysledek, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
    $error="Je to jiz dlouho od Vasi posledni aktivity, provedte prosim nove prihlaseni. ";
    header("Location:/logOut.php?errorUser=$error");
    session_destroy();
    die("Je to jiz dlouho od Vasi posledni aktivity, provedte prosim nove prihlaseni.");

}
else {
    try {  
        if (isset($_SESSION['aktivita']) && (time() - $_SESSION['aktivita'] <= 3600) && overovaniRelace()) {
            if (!isset($_SESSION['username'])) {
                $chyba = 'Přístup odepřen';
            } else {
                $pristup_zakazan = false;
                //session_regenerate_id();
            }
        } else {
            $chyba = 'Přístup odepřen';
            $vysledek = "Chyba ve fci overovaniUser: neaktivni,time:".time()."session:".$_SESSION['aktivita'];
            //zapis_log_login($_SESSION['username'], $vysledek, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
        }
    } catch (Exception $e) {

        $chyba = 'Nelze zpracovat požadavek"';

    }
}


?>
