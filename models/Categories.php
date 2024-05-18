<?php

  class Categories{
    private $table_name = 'categories', $conn;
    
    function __construct(){
      $this->conn = require $_SESSION['root_dir'] . '/config/dbconn.php';
    }

    function save($postArray){
      extract($postArray);
      try{
          $insert = "INSERT INTO {$this->table_name}(cat_name, price) VALUES (?, ?)";
          $stmt = $this->conn->prepare($insert);
          $array = array($name, $price);

          for($i = 0; $i < count($array); $i++){
              $stmt->bindValue($i+1, $array[$i]);
          }

          if(! $stmt->execute()){
              return [False, $this->conn->lastErrorMsg()];   
          }

          return [True, 'successful'];        
      }

      catch(\SQLite3Exception $e){
          return False;         
      }  
    }

    function read(){
      try{
        $select = "SELECT * FROM {$this->table_name}";
        $result = $this->conn->query($select);

        if (! $result){
          return null;
        }

        $cats = array();
        while($row = $result->fetchArray(SQLITE3_ASSOC)){
          array_push($cats, $row);
        }
        return $cats;

      }catch(SQLite3Exception $e){
        return null;
      }
    }

    function read_one($id = null){
      try{
        $select = "SELECT * FROM {$this->table_name} WHERE cat_id = ?";
  
        $stmt = $this->conn->prepare($select);
        $stmt->bindValue(1, $id);
        $result = $stmt->execute();
        $result = $this->conn->query($select);
  
        return $result->fetchArray(SQLITE3_ASSOC);

      }catch(SQLite3Exception $e){
        return null;
      }
    }

  }



?>