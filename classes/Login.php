<?php

/**
 * Created by PhpStorm.
 * User: ondrac
 * Date: 02.07.2018
 * Time: 9:30
 */
class Login
{
    protected $validate;
    protected $errorUser;
    protected $errorLog;
    protected $homeSite = "/index.php";
    private $username;
    private $homeSiteUser = "/vip/home.php";
    private $homeSiteAdmin = "/vip/home.php";

    public function __construct($username, $password)
    {
        require_once "../../includes/autoLoader.php";
        require_once "../../includes/function.php";
        $username = strtolower(htmlspecialchars(filter_var($username, FILTER_SANITIZE_STRING)));
        $this->homeSite = '/index.php';
        if (strlen($username) > 20 || strlen($username) < 3) {
            $this->errorUser = 'Chyba ověřování, zkontroluj username a heslo';
            $this->errorLog = 'chybi vstup';
            $this->validate = FALSE;
        } elseif (strlen($username) > 20 || strlen($username) < 3) {
            $this->errorUser = 'Chyba ověřování, zkontroluj username a heslo';
            $this->errorLog = 'chybny vstup';
            $this->validate = FALSE;
        } elseif (strlen($password) > 40 || strlen($password) < 4) {
            $this->errorUser = 'Chyba ověřování, zkontroluj username a heslo';
            $this->errorLog = 'chybny vstup heslo';
            $this->validate = FALSE;
        } elseif (!ctype_alnum(str_replace('.', '', $username))) {
            $this->errorUser = "Chyba ověřování, zkontroluj username a heslo";
            $this->errorLog = 'chybny vstup';
            $this->validate = FALSE;
        } elseif (filter_var($username, FILTER_SANITIZE_STRING) && !isset($this->validate)) {
            try {
                $db = new DatabaseConnector();
                $stmt = $db->getDbLink()->prepare("SELECT users.*, ou.name AS skupina, rangeRoleTypes.name as role FROM users JOIN ou USING (idOu) JOIN rangeRoleTypes USING(idRoleType) WHERE username = :username");
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->execute();
                $vysledek = $stmt->fetch();
                if (isset($vysledek)) {

                    if (isset($vysledek['accessDenied']) && !fail2ban($this->username) && $vysledek['accessDenied'] == '0') {
                        if (password_verify($password, $vysledek['password'])) {
                             $this->validate = TRUE;
                            if(session_status() != 2){
                                session_start();
                            }

                           setSessionTeammates(getTeammates($username));
                            $this->username = htmlspecialchars($username);
                            $_SESSION['username'] = $this->username;

                            $_SESSION['email'] = $vysledek['email'];
                            $_SESSION['jmeno'] = $vysledek['name'];
                            $_SESSION['ou'] = $vysledek['skupina'];
                            $_SESSION['role'] = $vysledek['role'];
                            $_SESSION['aktivita'] = time();
                            $_SESSION['ip_sezeni'] = sha1($_SERVER['REMOTE_ADDR']);
                            $_SESSION['agent'] = sha1($_SERVER['HTTP_USER_AGENT']);
                            $this->errorUser = $this->errorLog = "Prihlaseni probehlo, presmerovavam";
                            if ($_SESSION['role'] == 'admin') {
                                $this->homeSite = $this->homeSiteAdmin;
                            } 
                            elseif ($_SESSION['role'] == 'adminEditor' OR $_SESSION['role'] == 'editor') {
                                $this->homeSite = $this->homeSiteUser;
                            } 
                        }
                        elseif (!password_verify($password, $vysledek['password'])) {
                            $this->errorLog = "Neuspesne prihlaseni, spatne heslo.";
                            $this->errorUser = 'Špatné uživatelské jméno nebo heslo';
                        }
                    } else {
                        $this->errorLog = 'username neni v DB';
                        $this->errorUser = 'Špatné uživatelské jméno nebo heslo';
                    }
                }
                zapis_log_login($username, $this->errorLog, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
                echo $this->errorUser;
                $error = urlencode($this->errorUser);
                header("Location: $this->homeSite?errorUser=$error&token");
            } catch (Exception $e) {
                echo 'Caught exception: ', $e->getMessage(), "\n";
            }
        } 
        else {
            zapis_log_login($username, $this->errorLog, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
            die($this->errorUser);
        }

    }

    /**
     * @return string
     */
    public function getErrorUser()
    {
        return $this->errorUser;
    }


}