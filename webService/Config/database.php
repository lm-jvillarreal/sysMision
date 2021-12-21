<?php
class Database{

    // specify your own database credentials
    private $host = "74.208.211.84";
    private $db_name = "sysadmision2";
    private $username = "mision";
    private $password = "ABC1238f47";
    public $conn;

    // get the database connection
    public function getConnection(){

        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            //$this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
