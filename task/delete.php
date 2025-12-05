<?php
@include "conn.php";
$id = $_GET['id'];
$sql = "DELETE FROM task WHERE id='$id'";

if ($conn->query($sql)) {
  header("location: display.php");
} else {
  echo "Error deleting record: ";
}
?>