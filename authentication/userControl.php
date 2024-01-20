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
}

?>
