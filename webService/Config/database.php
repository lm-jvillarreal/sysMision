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
        //$conexion=mysqli_connect($db_host,$db_user,$db_pass,$db_name);


        $this->conn = null;
        $this->conn = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
        if(mysqli_connect_errno()){
         printf(mysqli_connect_error());
        }
        mysqli_set_charset($this->con, 'utf8');
        // try{
            
        //     //$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        //     //$this->conn->exec("set names utf8");
        // }catch(PDOException $exception){
        //     echo "Connection error: " . $exception->getMessage();
        // }

        return $this->conn;
    }
}
?>
