<?php
session_start();
@include "conn.php";

if (!isset($_SESSION['user_id'])) {
    header("location: /TODO/user/login_form.php");
    exit;
}
else
    {
        header("location:/TODO/task/dashboard.php");
    }
