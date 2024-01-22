<?php
require_once '../configuration/userControl.php' ;

// veiwFunction.php



// function for form 
function addTask($conn ,  $title, $name, $description, $assignee) {
    $min = 10000;
    $max = 99999;

    try {
        $user = new Model($conn);
<<<<<<< HEAD
        if ($assignee == "" || $title == ""){
            echo "Please check all details" ; 
            return False ; 
        }
=======

>>>>>>> 8f9b5718b8946a2b8ab98a71c9b2198a1a0df563
        $data = array(
            'id' => rand($min, $max),
            'title' => $title,
            'name' => $name,
            'description' => $description,
            'assignee' => $assignee
        );

        // Call the insertData function with the 'tasks' table and the data
        if ($user->insertData('tasks', $data)) {
<<<<<<< HEAD
            echo "Task added successfully 👍";
=======
            echo "Task added successfully";
>>>>>>> 8f9b5718b8946a2b8ab98a71c9b2198a1a0df563
        } else {
            echo "Failed to add task";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function taskList($conn,$username){
    try{
        $user = new Model($conn) ;

        $data = selectFromTable($conn , 'tasks', ['name'=>$username])  ;
        
        return $data ; 

    }catch(PDOException $e){
        echo "Error: ".$e->getMessage() ; 
    }
}


function deleteTask($id){
    echo "" ; 
}

function editTask($id){
    echo "" ; 
}


?>