<?php
session_start(); 
$conn = new mysqli("localhost", "root","", "db_pro2")
or die("error" . $conn->connect_error);
$username = $_SESSION['username'];
$accountid=$_POST["accountid"];
$conn->query("update accountinfo set creditcard=null where accountid='$accountid'");
header("Location:main.php");
?>