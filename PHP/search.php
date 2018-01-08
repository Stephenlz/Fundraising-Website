<?php 
$conn = new mysqli("localhost", "root","", "db_pro2")
or die("error" . $conn->connect_error);
session_start();
$username=$_SESSION['username'];
$keyword=$_POST["search"];
echo "<!DOCTYPE html>
	<html>
	<head lang='en'>
		<meta charset='UTF-8'>
		<title></title>
		<link rel='stylesheet' type='text/css' href='general.css'>
	</head>
	<body>
<div class=background></div>
	<div class = whiteboard0>
		<div class='topnav'>
			<a class='active' href='main.php'>Home</a>
			<a class='menu'>
			<div>
				<form method='post' action='peopleactivity.php'>
						<input type='submit' name='uname' style='font-size:18px;
																	background-color: transparent;
																	font-family:Comic Sans MS, cursive, sans-serif;
																	color:#fff; border:none;' 
																	value='my account'></input>
				</form>
			</div></a>
			<a class='menu' href='startaproject.php'>start a project</a>
			<a class='menu' href='tag.php'>tags</a>
			<a class='menu' href='history.php'>search history</a>
			<a class='menu' href='login.html'>log out</a>
			<div class = 'board0position1'>
				<form method='post' action='search.php'>
					<table><tr>
						<td><input type='text' name='search' style='font-size:20px'></input></td>
						<td><button class='searchbutton' type='submit'>search</button></td>
					</table></tr>
				</form>
			</div>
		</div>
	</div>
	<div class=searchboard>
	<p align= 'center'	style ='font-size:20px; color:#000;'>search result</p>
	<table>
		<thread>
		<tr>
			<th>Project Name</th>
			<th>Project Owner</th>
			<th>Description</th>
			<th>Post Time</th>
			<th>Project Status</th>
			<th>Money Raised</th>
			<th>Minimum Money to Start</th>
			<th>Project Start Time</th>
		</tr>";
$query = $conn->query("select distinct projects.pid,projects.pname, powner,description, requests.posttime, pstatus, sum(money) as sm, minfund,projects.starttime
	from fund join projects on fund.pid=projects.pid join requests on requests.pid=projects.pid
	where (fstatus = 'pending' or fstatus='charged') and projects.pname like '%{$keyword}%' or projects.description like '%{$keyword}%'
	group by projects.pid,powner, requests.posttime, pstatus,minfund,projects.starttime
    order by requests.posttime desc") 
or die("SQL Failed");

if ($query->num_rows > 0){
	$conn->query("insert into searchedkeywords values('$username','$keyword',default)")
 or die("SQL Failed");
	while($row=mysqli_fetch_assoc($query)){
		echo "<tr><td><form action='project.php' method='post'>
		<input type = 'submit' class='but-left' name = 'uname' value = '$row[pname]'>
		<input type='hidden' name='pid' value='$row[pid]'></form></td>
		<td><form action='peopleactivity.php' method='post'><input type = 'submit' class='but-left' name = 'uname' value = '$row[powner]'></form></td><td>".$row["description"]."</td><td>".$row["posttime"]."</td><td>".$row["pstatus"]."</td><td>".$row["sm"]."</td><td>".$row["minfund"]."</td><td>".$row["starttime"]."</td></tr>";
	}
	echo "</table></div>";
}
echo"</body>
</html>";
?>