<?php
@include "conn.php";

$id=$_POST['id'];
$taskname=$_POST["name"];
$description=$_POST["description"];
$priority=$_POST["priority"];
$duedate=$_POST["duedate"];
  
$sql = "UPDATE task SET `taskname`='$taskname',`description`='$description',`priority`='$priority',`duedate`='$duedate' WHERE id='$id'";

if ($conn->query($sql)) {
  header("location: display.php");
} else {
  echo "Error updating record: ";
}