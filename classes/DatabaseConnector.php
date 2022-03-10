<?php

/**
 * Created by PhpStorm.
 * User: ondrac
 * Date: 14.05.2018
 * Time: 8:34
 */
class DatabaseConnector
{
    private $server;
    private $userDb;
    private $passDb;
    private $dbName;
    protected $options;
    protected $link;
    protected $dbLink;

    /**
     * database constructor.
     * @param $
     */
    public function __construct()
    {
        require_once __DIR__."/../conf/conf.php";
        $connectionDb = getConnection();
        $this->server = $connectionDb['server'];
        $this->userDb = $connectionDb['userDb'];
        $this->passDb = $connectionDb['passDb'];
        $this->dbName = $connectionDb['dbName'];

        $this->options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );
        $this->link = mysqli_connect($this->server, $this->userDb, $this->passDb, $this->dbName);
        $this->dbLink = new PDO("mysql:host=$this->server;dbname=$this->dbName", $this->userDb, $this->passDb,$this->options);
        $this->dbLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (!$this->link) {
            $chyba = "Nelze se pripojit k serveru DB, zkontroluj nastavení.(1)";
            echo $chyba;
            exit();

        } else {
            return TRUE;
        }
    }

    public function select($table, $where)
    {
        try {
            $stmt = $this->dbLink->prepare("SELECT * FROM $this->dbName.$table WHERE $where");
            $stmt->execute();
            $vys = $stmt->fetchAll();
            return $vys;
        } catch (Exception $e){
            echo "Chyba v DB", $e->getMessage(), "\n";
        }
        
    }

    /**
     * @return PDO
     */
    public function getDbLink()
    {
        return $this->dbLink;
    }

}