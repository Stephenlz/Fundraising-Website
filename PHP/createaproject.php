<?php
session_start(); 
$conn = new mysqli("localhost", "root","", "db_pro2")
or die("error" . $conn->connect_error);

$username = $_SESSION['username'];
$query=$conn->query("select accountid,creditcard from accountinfo where uname='$username'") 
or die("SQL Failed"); 
$username=$_SESSION["username"];
$pname=$_POST["pname"];
$description=$_POST["description"];
$accountid=$_POST["accountid"];
$minfund=$_POST["minfund"];
$maxfund=$_POST["maxfund"];
$stoptime=$_POST["stoptime"];
$tag1=$_POST['tag1'];
$tag2=$_POST['tag2'];
$query=$conn->query("select max(pid) as largestpid from projects") or die("error1" . $conn->connect_error);
$row=mysqli_fetch_assoc($query);
$pid=$row["largestpid"]+1;
$conn->query("insert into projects values ('$pid','$pname','$username','$description',default,default,default)")or die("error2" . $conn->connect_error);
$conn->query("insert into requests values ('$pid',default,'$accountid','$minfund','$maxfund','$stoptime','active',default,default)")or die("error3" . $conn->connect_error);
$conn->query("insert into tags values('$pid','$tag1')");
$conn->query("insert into tags values('$pid','$tag2')");
header("location:main.php");
?>