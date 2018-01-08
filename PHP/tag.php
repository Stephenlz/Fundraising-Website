<?php 
$conn = new mysqli("localhost", "root","", "db_pro2")
or die("error" . $conn->connect_error);
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
	</div>";
session_start();
$username=$_SESSION['username'];
$query = $conn->query("select distinct tag from tags") or die("SQL Failed");
echo "<div class=tagboard><p align= 'center'	style ='font-size:20px; color:#000;'>tags</p>";
if ($query->num_rows > 0){
	echo "<table>";
	while($row=mysqli_fetch_assoc($query)){
		echo "<tr><td><a href='searchbytag.php?tag={$row['tag']}'>".$row["tag"]."</td>";
		$numrows=0;
		while($row=mysqli_fetch_assoc($query) and $numrows<6){
			echo "<td><a href='searchbytag.php?tag={$row['tag']}'>".$row["tag"]."</td>";
			$numrows++;
		}
		echo"</tr>";
	}
	$num_rows=0;

	echo "</table>";
}
echo"</div></body>
</html>";
?>