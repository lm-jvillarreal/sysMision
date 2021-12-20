<?php

    class Areas{
      // database connection and table name
      private $conn;
      private $table_name = "areas";

      public $id;
      public $nombre;
      public $id_sucursal;

      public function __construct($db){
          $this->conn = $db;
      }


    public function read(){
          $query = "CALL GetAreasMtto(:pIdSucursal)";
          $stmt = $this->conn->prepare( $query );
          $stmt->bindParam(':pIdSucursal', $this->id_sucursal);
          $stmt->execute();
          return $stmt;
    }




    }
 ?>
