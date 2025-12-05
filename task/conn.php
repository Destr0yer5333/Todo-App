<?php
$servername="localhost";
$username="root";
$password="";
$database="todo_list";

$conn= new mysqli ($servername,$username,$password,$database);
if($conn->connect_error)
    {
        die ("Connection Failed");
    } 
?>