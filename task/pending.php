<?php
session_start();
@include 'conn.php';

$id = $_GET['id'];
$user_id=$_SESSION['user_id'];
$sql = "UPDATE task SET status = 0 WHERE id = $id AND user_id = '$user_id'";
mysqli_query($conn, $sql);

header("Location: display.php");
exit;
?>
