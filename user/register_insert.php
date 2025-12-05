<?php
session_start();
@include "../task/conn.php";

if (isset($_POST['register'])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $ins = "INSERT INTO user(`username`, `email`, `password`) 
            VALUES('$username', '$email', '$password')";
    if ($conn->query($ins)) {
        header("location: login_form.php");
    } else {
        echo "Not Added";
    }
}

if (isset($_POST['login'])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM user 
            WHERE username = '$username' 
            AND password = '$password'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        // FETCH THE USER
        $row = $result->fetch_assoc();

        // SAVE BOTH NAME AND ID IN SESSION
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_id']  = $row['id'];

        header("location: ../task/dashboard.php");
        exit;

    } else {
        echo "Invalid username or password";
        header("location: login_form.php");
    }
}
?>
