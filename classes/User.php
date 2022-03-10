<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 02.01.2020
 * Time: 13:59
 */

class User
{
    protected $dbh;
    protected $password;
    protected $username;

    public function __construct($username, $name, $email, $role, $ou , $password, $accessDenied = 0){
        $this->dbh = new DatabaseConnector();
        $this->username = $username;
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
        $this->ou = $ou;
        $this->password = $password;
        $this->accessDenied = $accessDenied;
    }

    public function getRole(){
        try {
            $stmt = $this->dbh->getDbLink()->prepare("SELECT name FROM rangeRoleTypes WHERE idRoleType = :idRoleType");
            $stmt->bindParam(':idRoleType', $this->role, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['name'];
        } catch (OutOfBoundsException $e){
            echo 'Unknown role: ', $e->getMessage(), "\n";
            return null;
        }
    }

    public function getOu(){
        try {
            $stmt = $this->dbh->getDbLink()->prepare("SELECT name FROM ou WHERE idOu = :idOu");
            $stmt->bindParam(':idOu', $this->ou, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['name'];
        } catch (OutOfBoundsException $e){
            echo 'Unknown role: ', $e->getMessage(), "\n";
            return null;
        }
    }

    public function hashPassword($password){
        $this->password = User::encryptPassword($password);
    }

    public function setPassword($password){
        $this->password = User::encryptPassword($password);
        $this->toDb();
    }

    public function toDb(){
        try{
            /*
            $stmt = $this->dbh->getDbLink()->prepare("INSERT INTO users VALUES (:username,:name, :idOu, :idRoleType, 1, :email, NULL, :password, :accessDenied, NOW()) 
            ON DUPLICATE KEY UPDATE username=:username, name=:name, idOu=:idOu, idRoleType=:idRoleType, idAuthorityType=1, email=:email, updated=NOW(), password=:password, accessDenied=:accessDenied");
            */
            $stmt = $this->dbh->getDbLink()->prepare("INSERT INTO users VALUES (:username,:name, :idOu, :idRoleType, 1, :email, NULL, :password, :accessDenied, NOW())");
            $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
            $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindParam(':idOu', $this->ou, PDO::PARAM_INT);
            $stmt->bindParam(':idRoleType', $this->role, PDO::PARAM_INT);
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
            $stmt->bindParam(':accessDenied', $this->accessDenied, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        }catch(Exception $e){
            echo 'Unknown role: ', $e->getMessage(), "\n";
            return false;
        }
    }

    public function authneticate($password){
        password_verify($password, $this->password);
    }

    public static function encryptPassword($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public  static function fromDb($username){
        $instance = null;
        try {
            $dbh = new DatabaseConnector();
            $stmt = $dbh->getDbLink()->prepare('SELECT username, name, idOu, role, email, password, accessDenied FROM suspensions WHERE username =:username LIMIT 1');
            $stmt->bindParam(':username', $username, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $instance = new User($result['username'],$result['name'], $result['email'], $result['role'], $result['idOu'], $result['password']);
        } catch (OutOfBoundsException $e){
            echo 'Unknown role: ', $e->getMessage(), "\n";
        }
        return $instance;
    }
}