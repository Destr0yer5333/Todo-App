<?php
session_start();
@include "conn.php";
$user_id = $_SESSION['user_id']; 
$task = $_POST['task'];

$taskname=$_POST["name"];
$description=$_POST["description"];
$priority=$_POST["priority"];
$duedate=$_POST["duedate"];

$ins="INSERT INTO task(`taskname`,`description`,`priority`,`duedate`,`status`,`user_id`) VALUES('$taskname','$description','$priority','$duedate',0,'$user_id')";
if($conn->query($ins))
{
    header("location:display.php");
}
else
{
    echo "Not Added";
}

?>