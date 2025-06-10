<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}












//Then include it in any page you want to protect:
//require_once 'includes/auth.php';