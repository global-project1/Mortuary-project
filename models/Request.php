<?php

    class Request{
        private $conn, $table_name = "request";

        function __construct(){
            $this->conn = require $_SESSION['root_dir'] . '/config/dbconn.php';
        }

        function save(){

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
                // Set the global variable
                if(! $condition){
                    $_SESSION['all_corpse'] = $results;
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

        function update( $id = null, $col = null, $value = null  ){
            try{
                $insert = "UPDATE {$this->table_name} SET $col = ? WHERE week_day = ?";

                $stmt = $this->conn->prepare($insert);
                $stmt->bindValue(1, $value);
                $stmt->bindValue(2, $id);
                
                // else{
                //     $insert = "UPDATE {$this->table_name} SET $string WHERE id = '$id'";
                //     $stmt = $this->conn->prepare($insert);

                //     echo $stmt;
                //     die;
                // }
                
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