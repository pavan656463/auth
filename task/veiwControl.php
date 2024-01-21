<?php
// form for submit task 



session_start()  ; 

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'] ; 
    echo "Logged as ".$username  ;
}else{ 
    echo "Not logged" ; 
}

?> 