<?php 
$conn = new mysqli("localhost", "root","", "db_pro2")
or die("error" . $conn->connect_error);
session_start();
$username=$_SESSION["username"];
echo "<!DOCTYPE html>
	<html>
	<head lang='en'>
		<meta charset='UTF-8'>
		<title></title>
		<link rel='stylesheet' type='text/css' href='main.css'>
	</head>
	<body>
	<div class=background>
	</div>
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

	<div class=whiteboard1>
	<p align= 'center'	style ='font-size:20px; color:#000;'><a href='projectslist.php'>project</a></p>";
$query = $conn->query("select distinct projects.pid,projects.pname, powner, requests.posttime, pstatus, sum(money) as sm, minfund,projects.starttime
	from fund join projects on fund.pid=projects.pid join requests on requests.pid=projects.pid
	where (fstatus = 'pending' or fstatus='charged') and requests.posttime>date_add(current_timestamp(), interval -3 month)
	group by projects.pid,powner, requests.posttime, pstatus,minfund,projects.starttime
    order by requests.posttime desc") 
or die("SQL Failed");
if ($query->num_rows > 0){
	echo "
	<table>
		<tr>
			<th>Project Name</th>
			<th>Owner</th>
			<th>Post Time</th>
			<th>Status</th>
			<th>Money Raised</th>
			<th>Minimum Money to Start</th>
			<th>Launch Time</th>
		</tr>";
	while($row=mysqli_fetch_assoc($query)){
		echo "<tr><td><form action='project.php' method='post'>
		<input type = 'submit' class='but-left' name = 'uname' value = '$row[pname]'>
		<input type='hidden' name='pid' value='$row[pid]'></form></td>
		<td>
		<form action='peopleactivity.php' method='post'><input type = 'submit' class='but-left' name = 'uname' value = '$row[powner]'>
		</form></td>
		<td>".$row["posttime"]."</td>
		<td>".$row["pstatus"]."</td>
		<td>".$row["sm"]."</td>
		<td>".$row["minfund"]."</td>
		<td>".$row["starttime"]."</td>
		</tr>";
	}
	echo "</table></div>";
}
$sql="select  distinct projects.pid,pname,powner,description,pstatus from projects left join tags on projects.pid=tags.pid";
$subquery = $conn->query("select distinct keyword from searchedkeywords where uname='$username'") or die("SQL Failed");
$numberofselectioncondition=0;
if ($subquery->num_rows > 0){
	while($row=mysqli_fetch_assoc($subquery)){
		if($numberofselectioncondition==0){
			$sql=$sql." where description like '%" .$row["keyword"]."%' or pname like '%".$row["keyword"]."%'";
			$numberofselectioncondition=1;
		}else{
			$sql=$sql." or description like '%" .$row["keyword"]."%' or pname like '%".$row["keyword"]."%'";
		}
	}
}
$subquery = $conn->query("select distinct tag from searchedtags where uname='$username'") or die("SQL Failed");
if ($subquery->num_rows > 0){
	while($row=mysqli_fetch_assoc($subquery)){
		if($numberofselectioncondition==0){
			$sql=$sql." where tag = '" .$row["tag"]."'";
			$numberofselectioncondition=1;
		}else{
			$sql=$sql." or tag = '" .$row["tag"]."'";
		}
	}
}
$sql=$sql." order by rand() limit 5";
$query=$conn->query($sql) or die("SQL Failed");
echo "<div class=whiteboard2>
	<p align= 'center'	style ='font-size:20px; color:#000;'>guess you like</p>";
if ($query->num_rows > 0){	
	echo "
	<table>
		<tr>
			<th>Project Name</th>
			<th>Owner</th>
			<th>Description</th>
			<th>Status</th>
		</tr>";
	while($row=mysqli_fetch_assoc($query)){
		echo "<tr><td><form action='project.php' method='post'>
		<input type = 'submit' class='but-left' name = 'uname' value = '$row[pname]'>
		<input type='hidden' name='pid' value='$row[pid]'></form></td>
		<td><form action='peopleactivity.php' method='post'><input type = 'submit' class='but-left' name = 'uname' value = '$row[powner]'></form></td><td>".substr($row["description"], 0, 50)."</td><td>".$row["pstatus"]."</td></tr>";
	}	
}
echo "</table></div>";
$query = $conn->query("select distinct projects.pid,pname, uname, comments, iflike, comments.posttime
from follower join comments on follower.blogger=comments.uname join projects on projects.pid=comments.pid
where follower.follower='$username' and comments.posttime>date_add(current_timestamp(), interval -30 day)
order by comments.posttime desc;")
or die("SQL Failed");
echo "<div class=whiteboard3>
	<p align= 'center'	style ='font-size:20px; color:#000;'>moments</p>";
if ($query->num_rows > 0){
	echo "
	<table>
		<tr>
			<th>Project Name</th>
			<th>Commentor</th>
			<th>Comments</th>
			<th>Attitude</th>
		</tr>";
	while($row=mysqli_fetch_assoc($query)){
		if($row["iflike"]==1)
		echo "<tr><td><form action='project.php' method='post'>
		<input type = 'submit' class='but-left' name = 'uname' value = '$row[pname]'>
		<input type='hidden' name='pid' value='$row[pid]'></form></td>
		<td><form action='peopleactivity.php' method='post'><input type = 'submit' class='but-left' name = 'uname' value = '$row[uname]'></form></td><td>".substr($row["comments"], 0, 30)."</td><td>Positive</td></tr>";
	else
		echo "<tr><td><a class=aintables href='recoredsearchedprojects.php?pid={$row['pid']}'>".$row["pname"]."</a></td><td><input type = 'submit' class='but-left' name = 'uname' value = '$row[uname]'></td><td>".$row["comments"]."</td><td>Negative</td></tr>";
	}
}
echo "</table>";

$query = $conn->query("select distinct projects.pid,accountinfo.uname,pname, money, fund.starttime
from follower join accountinfo on follower.blogger=accountinfo.uname join fund on accountinfo.accountid=fund.accountid join projects on projects.pid=fund.pid
where follower='$username' and fund.starttime>date_add(current_timestamp(), interval -30 day)
order by fund.starttime desc");
echo "<p align= 'center'	style ='font-size:20px; color:#000;'>donation</p>";
if ($query->num_rows > 0){
	echo "<table>
		<tr>
			<th>Project Name</th>
			<th>Donator</th>
			<th>money</th>
			<th>Pledge Time</th>
		</tr>";
	while($row=mysqli_fetch_assoc($query)){
	echo "<tr><td><form action='project.php' method='post'>
		<input type = 'submit' class='but-left' name = 'uname' value = '$row[pname]'>
		<input type='hidden' name='pid' value='$row[pid]'></form></td><td><form action='peopleactivity.php' method='post'><input type = 'submit' class='but-left' name = 'uname' value = '$row[uname]'></form></td><td>".$row["money"]."</td><td>".$row["starttime"]."</td></tr>";
	}
}
echo "</table>";

$query = $conn->query("select distinct projects.pid, pname,entries.posttime,ename
from projects natural join entries
where projects.pid in (select projects.pid from projects join fund on projects.pid=fund.pid join accountinfo on fund.accountid=accountinfo.accountid where uname='BobInBrooklyn')
or projects.pid in (select projects.pid from projects natural join comments where uname='BobInBrooklyn' and iflike=1) and entries.posttime>date_add(current_timestamp(), interval -30 day)
order by entries.posttime desc");
echo "<p align= 'center'	style ='font-size:20px; color:#000;'>project post</p>";
if ($query->num_rows > 0){
	echo "<table>
		<tr>
			<th>Project Name</th>
			<th>Description</th>
			<th>Post Time</th>
		</tr>";
	while($row=mysqli_fetch_assoc($query)){
	echo "<tr><td><form action='project.php' method='post'>
		<input type = 'submit' class='but-left' name = 'uname' value = '$row[pname]'>
		<input type='hidden' name='pid' value='$row[pid]'></form></td><td>".$row["ename"]."</td><td>".$row["posttime"]."</td></tr>";
	}
}
echo "</table>";
echo "</div>";
echo"</body>
</html>";
?>