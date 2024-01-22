<?php
require_once 'config.php' ; 

class Model {
    private $db; 

    public function __construct($db){
        $this->db = $db; 
    }

    public function getUserDetails(){
        try {
            $stmt = $this->db->query("select * from  users");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "".$e->getMessage() ;  
            return false;
        }
    }

    // register user details 

    public function registerUser($email , $username , $password){
        try{
            // Check if the database connection is valid
            $stmt = $this->db->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)") ; 
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            if($stmt->execute()){
                return True  ; 
            }else {
                return False ; 
            }

        } catch(PDOException $e){
            echo "".$e->getMessage() ; 
            return false;
        }
    }

    public function authenticateUser($username, $password){
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
    
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if(empty($user)){
                return False ; 
            }
            if ($password == $user['password']){
                return True ; 
            }else{
                return False ; 
            }
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    public function insertData($table, $data){
        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
    
        try {
            $stmt = $this->db->prepare("INSERT INTO $table ($columns) VALUES ($values)");
    
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            if ($stmt->execute()){
                return True ; 
            }else{
                return False ; 
            }
            
    
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    }

    function selectFromTable($conn, $tableName, $parameters = array()) {
        try {
            $sql = "SELECT * FROM $tableName";
    
            // Build the WHERE clause if parameters are provided
            if (!empty($parameters)) {
                $conditions = array();
    
                foreach ($parameters as $key => $value) {
                    // Ensure the key is a valid column name to prevent SQL injection
                    $key = preg_replace('/[^a-zA-Z0-9_]/', '', $key);
    
                    // Use placeholders in the WHERE clause
                    $conditions[] = "$key = :$key";
                }
    
                $sql .= " WHERE " . implode(' AND ', $conditions);
            }
    
            $stmt = $conn->prepare($sql);
    
            // Bind parameters if any
            foreach ($parameters as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
    
            $stmt->execute();
    
            // Fetch the results as an associative array
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;
        } catch (PDOException $e) {
            // Handle exceptions as needed
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    function deleteFromTable($conn, $tableName, $conditions = array()) {
        try {
            // Ensure the table name is a valid table name to prevent SQL injection
            $tableName = preg_replace('/[^a-zA-Z0-9_]/', '', $tableName);
    
            $sql = "DELETE FROM $tableName";
    
            // Build the WHERE clause if conditions are provided
            if (!empty($conditions)) {
                $whereConditions = array();
    
                foreach ($conditions as $key => $value) {
                    // Ensure the key is a valid column name to prevent SQL injection
                    $key = preg_replace('/[^a-zA-Z0-9_]/', '', $key);
    
                    // Use placeholders in the WHERE clause
                    $whereConditions[] = "$key = :$key";
                }
    
                $sql .= " WHERE " . implode(' AND ', $whereConditions);
            } else {
                // If no conditions are provided, prevent accidental deletion of all records
                throw new InvalidArgumentException("Conditions are required for DELETE operation");
            }
    
            $stmt = $conn->prepare($sql);
    
            // Bind parameters if any
            foreach ($conditions as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
    
            $stmt->execute();
    
            // Return true indicating successful deletion
            return true;
        } catch (PDOException $e) {
            // Handle exceptions as needed
            // You may log the error or perform additional actions
            return false;
        } catch (InvalidArgumentException $e) {
            // You may log the error or perform additional actions
            return false;
        }
    }
    
    
    


?>

