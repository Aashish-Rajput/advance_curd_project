<?php
class Database{
    private $dbserver= "localhost";
    private $dbuser = "root";
    private $password = "";
    private $dbname = "userdata";
    protected $conn;


    // constructor
    public function __construct(){
   
        try{

            $dsn = "mysql:host={$this->dbserver}; dbname={$this->dbname}; charset=utf8";
            $option = array(PDO::ATTR_PERSISTENT);
            $this->conn = new PDO($dsn,$this->dbuser, $this->password ,$option);
    
        }
        catch(PDOException $e){
            echo "connection Error".$e->getMessage();
            }
    }
}

?>
