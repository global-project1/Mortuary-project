<?php

    class Request{
        private $conn, $table_name = "request";

        function __construct(){
            $this->conn = require $_SESSION['root_dir'] . '/config/dbconn.php';
        }

        function read($condition = null){
            try{
                if ($condition){
                    $select = "SELECT * FROM $this->table_name $condition";
                }
                else{
                    $select = "SELECT * FROM $this->table_name";
                }
                $result = $this->conn->query($select);
                if(! $result){
                    return [false, "No such record found"];
                }
                $results = array();

                while($row = $result->fetchArray(SQLITE3_ASSOC)){
                    array_push($results, $row);
                }
                return [true, $results];
            }
            catch(Exception $e){
                return [false, $this->conn->lasErrorMsg()];
            }       
        }

        function read_one($value){
            try{
                $value = $this->conn->escapeString($value);
    
                $select = "SELECT * FROM {$this->table_name} WHERE week_day = ?";
                $stmt = $this->conn->prepare($select);
                $stmt->bindValue(1, $value);
                $result = $stmt->execute();
                
                if($result){
                    return $result->fetchArray(SQLITE3_ASSOC);
                }   
                return false;  
            }
            catch(Exception $e){
                return false;
            }
        }

        function update( $string = null, $id = null, $col = null, $value = null  ){
            try{
                if(!$string){
                    $insert = "UPDATE {$this->table_name} SET $col = ? WHERE week_day = ?";
                    $stmt = $this->conn->prepare($insert);
                    $stmt->bindValue(1, $value);
                    $stmt->bindValue(2, $id);
                }
                else{
                    $insert = "UPDATE {$this->table_name} SET $string WHERE week_day = ?";
                    $stmt = $this->conn->prepare($insert);
                    $stmt->bindValue(1, $id);
                }
                if(! $stmt->execute()){  
                    return [False, $this->conn->lastErrorMsg()];   
                }
                return [True, "success"];        
            }
            catch(\SQLite3Exception $e){
                return [False, $e];         
            }  
        }
    }

?>