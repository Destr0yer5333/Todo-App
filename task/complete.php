<?php
session_start();
@include "conn.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $sql = "UPDATE task SET status = 1  WHERE id = $id AND user_id = '$user_id'";

    if ($conn->query($sql)) {
        header("Location: display.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "No ID provided!";
}
?>
