<?php 
$conn = new mysqli("localhost", "root","", "db_pro2")
or die("error" . $conn->connect_error);
session_start();
$username=$_SESSION['username'];
$pid=$_GET['pid'];
$conn->query("insert into searchedprojects values('$username','$pid',default)")
 or die("SQL Failed");
$query=$conn->query("select distinct tag 
from tags join searchedprojects on tags.pid=searchedprojects.pid
where tags.pid='$pid'");
if ($query->num_rows > 0){
	while($row=mysqli_fetch_assoc($query)){
		$tag=$row["tag"];
		$conn->query("insert into searchedtags values('$username','$tag',default)")
 or die("SQL Failed");
	}
}
header("Location:project.php?pid=".$pid);
?>