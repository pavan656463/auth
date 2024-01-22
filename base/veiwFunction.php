<?php
require_once '../configuration/userControl.php' ;

// veiwFunction.php



// function for form 
function addTask($conn ,  $title, $name, $description, $assignee) {
    $min = 10000;
    $max = 99999;

    try {
        $user = new Model($conn);
        if ($assignee == "" || $title == ""){
            echo "Please check all details" ; 
            return False ; 
        }
        $data = array(
            'id' => rand($min, $max),
            'title' => $title,
            'name' => $name,
            'description' => $description,
            'assignee' => $assignee
        );

        // Call the insertData function with the 'tasks' table and the data
        if ($user->insertData('tasks', $data)) {
            echo "Task added successfully 👍";
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