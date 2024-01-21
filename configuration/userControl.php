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
    
            return $stmt->execute();
    
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
      }
      


?>
