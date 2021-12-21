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

        /* Connect to a MySQL database using driver invocation */
            $dsn_p = 'mysql:dbname=sysadmision2;host=74.208.211.84';
            $user_p = 'mision';
            $password_p = 'ABC1238f47';

            $dbh = new PDO($dsn, $user, $password);

        $this->conn = null;
        try{
            $this->conn = new PDO($dsn_p, $user_p, $password_p);
            //$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            //$this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
