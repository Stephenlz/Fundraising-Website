<?php
session_start(); 
$conn = new mysqli("localhost", "root","", "db_pro2")
or die("error" . $conn->connect_error);
$creditcard=$_POST["creditcard"];
$username=$_SESSION["username"];
$query=$conn->query("select max(accountid) as largestaccountid from accountinfo") or die("error1" . $conn->connect_error);
$row=mysqli_fetch_assoc($query);
$accountid=$row["largestaccountid"]+1;
$query=$conn->query("select creditcard from accountinfo where uname='$username'") or die("error3" . $conn->connect_error);
$exist=0;
while ($row=mysqli_fetch_assoc($query)) {
	if($creditcard==$row["creditcard"]){
		$exist=1;
	}
}
if($exist==1){
	echo"<!DOCTYPE html>
	<html>
	<head lang='en'>
		<meta charset='UTF-8'>
		<title></title>
		<link rel='stylesheet' type='text/css' href='main.css'>
	</head>
	<body>
	<a href='main.php'>The card has already been bounded to your account!</a>
	</body>
</html>";
}else{
	$conn->query("insert into accountinfo values ('$accountid','$username','$creditcard')")or die("error2" . $conn->connect_error);
	header("location:main.php");
}
?>