<?php
$conn = new mysqli("localhost", "root","", "db_pro2")
or die("error" . $conn->connect_error);

$pid = $_POST['pid'];
$ename = $_POST['ename'];
$query = $conn->query("select files, type from entries where pid = '$pid' and ename = '$ename'") 
or die("SQL Failed");
$row = $query->fetch_row(); 
$type =  $row[1];
header( "Content-type: $type");   		
echo $row[0];
?>