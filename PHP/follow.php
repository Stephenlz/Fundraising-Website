<?php
session_start(); 
$conn = new mysqli("localhost", "root","", "db_pro2")
or die("error" . $conn->connect_error);
$username = $_SESSION['username'];
$blogger=$_POST["uname"];
$conn->query("insert into follower values('$username','$blogger')");
header("Location:main.php");
?>