<?php
session_start(); 
$conn = new mysqli("localhost", "root","", "db_pro2")
or die("error" . $conn->connect_error);
$uname = $_POST['uname'];
$username = $_SESSION['username'];
if($uname == 'my account')$uname = $username;

$query1 = $conn->query("select loginname, email, hometown,interest from users where uname = '$uname'") 
or die("SQL1 Failed");

$query2 = $conn->query("select pid, pname, starttime, pstatus from projects where powner = '$uname'") 
or die("SQL2 Failed"); 

$query3 = $conn->query("select pid, pname, posttime, comments from projects natural join comments where uname = '$uname'") 
or die("SQL3 Failed"); 

$query4 = $conn->query("select p.pid, p.pname, f.money, f.starttime, f.fstatus from projects p 
																		join fund f on p.pid = f.pid
																		join accountinfo a on f.accountid = a.accountid
																		where uname = '$uname'") 
or die("SQL4 Failed"); 

$query5 = $conn->query("select blogger from follower where follower = '$uname'") 
or die("SQL5 Failed"); 

$query6 = $conn->query("select follower from follower where blogger = '$uname'") 
or die("SQL6 Failed");

$query7=$conn->query("select accountid,creditcard from accountinfo where uname='$username'") 
or die("SQL7 Failed"); 

$query8=$conn->query("select blogger from follower where follower='$username'")
or die("SQL 8 Failed");


echo"
<!DOCTYPE html>  
<html lang='en'>
<head>  
    <meta charset='UTF-8'>  
    <title>project</title>  
    <link rel='stylesheet' type='text/css' href='style3.css'/>  
</head>  
<body> 
	<div class = 'bg'></div>
	<div class = 'whiteboard0'>
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
	
	<div class = 'whiteboard1'>
		<h2 align = 'center'> profile</h2>
		<div class = 'whiteboard-inner1'>
			<table>";
			
if($row1 = $query1->fetch_row()){
	echo"<tr>
			<td style = 'min-width:50px'><p></p></td>
			<td><p class='but-left'>Nickname:</p></td>			
			<td><p class='but-right'>$row1[0]</p></td>
		</tr>
		<tr><td><p></p></td></tr>
		<tr>
			<td><p></p></td>
			<td><p class='but-left'>Email:</p></td>			
			<td><p class='but-right'>$row1[1]</p></td>
		</tr>
		<tr><td><p></p></td></tr>
		<tr>
			<td><p></p></td>
			<td><p class='but-left'>Hometown:</p></td>			
			<td><p class='but-right'>$row1[2]</p></td>
		</tr>
		<tr><td><p></p></td></tr>";
if($uname == $username){
	echo"	<tr>
			<td><p></p></td>
			<td><p class='but-left'>creditcard:</p></td>
			<td>
			<select>";
	while($row7 = $query7->fetch_row()){
		if ($row7[1]!=null)
			echo "<option name = 'accountid' value='$row7[0]'>".$row7[1]." </option>";
	}
	echo"</select>
		</td>
		</tr>
		<tr><td><p></p></td></tr>";
}
echo"
		<tr>
			<td><p></p></td>
			<td><p class='but-left'>Interest:</p></td>			
			<td><p class='but-right'>$row1[3]</p></td>
		</tr>";
}				
echo"				
			</table>
		</div>
		<div class='board1position1'>";
if($uname == $username){
	echo"
			<form method='post' action='profile.php'>
				<input type = 'submit' class='but-left' name = 'uname' value = 'edit'>
			</form>";
}
else{
	$iffollowing=0;
	while($row8=$query8->fetch_row()){
		if($row8[0]==$uname){
			$iffollowing=1;
		}
	}
	if($iffollowing==0){
		echo"
		<form method='post' action='follow.php'>
			<input type='hidden' name='uname' value='$uname'>
			<input type = 'submit' class='but-left' value = 'follow'>
		</form>";	
	}else{
		echo"
		<form method='post' action='unfollow.php'>
			<input type='hidden' name='uname' value='$uname'>
			<input type = 'submit' class='but-left' value = 'unfollow'>
		</form>";	
	}
}
echo"	</div>
	</div>
	
	<div class = 'whiteboard2'>
		<h2 align = 'center'> projects</h2>
		<div class = 'whiteboard-inner1'>		
			<table>";
			
$num = 1;			
while($row2 = $query2->fetch_row()){
	echo"
		<form name='form2' method='post' action='project.php'>
		<input type='hidden' name='pid' value='$row2[0]'>
		<tr>
			<td>$num.</td>
			<td><input type = 'submit' class='but-left' name = 'pname' value = '$row2[1]'></td>			
			<td><p class='but-middle'>$row2[2]</p></td>
			<td><p class='but-right'>$row2[3]</p></td>
		</tr>
		<tr><td><p></p><td></tr>
		</form>";
	$num = $num + 1;		
}

echo"				
			</table>
	</div>
	</div>
	<div class = 'whiteboard3'>
		<h2 align = 'center'> comments</h2>
		<div class = 'whiteboard-inner1'>	
			<table>";
			
$num = 1;			
while($row3 = $query3->fetch_row()){
	echo"
		<form name='form3' method='post' action='project.php'>
		<input type='hidden' name='pid' value='$row3[0]'>
		<tr>
			<td>$num.</td>
			<td><input type = 'submit' class='but-left' name = 'pname' value = '$row3[1]'></td>			
			<td><p class='but-right'>$row3[2]</p></td>
		</tr>
		<tr>
			<td><p></p></td>
			<td><p></p></td>			
			<td><p class='but-right'>$row3[3]</p></td>
		</tr>
		<tr><td><p></p><td></tr>
		</form>";
	$num = $num + 1;	
}

echo"				
			</table>	
		</div>
	</div>

	<div class = 'whiteboard4'>
		<h2 align = 'center'> pledge </h2>
		<div class = 'whiteboard-inner1'>
			<table>";
$num = 1;			
while($row4 = $query4->fetch_row()){
	echo"
		<form name='form4' method='post' action='project.php'>
		<input type='hidden' name='pid' value='$row4[0]'><tr>
			<td>$num.</td>
			<td><input type = 'submit' class='but-left' name = 'pname' value = '$row4[1]'></td>			
			<td><p class='but-middle'>$$row4[2]</p></td>
			<td><p class='but-middle'>$row4[3]</p></td>
			<td><p class='but-right'>$row4[4]</p></td>
		</tr>
		<tr><td><p></p><td></tr>
		</form>";
	$num = $num + 1;		
}
echo"				
			</table>		
		</div>
	</div>
	
	<div class = 'whiteboard5'>
		<h2 align = 'center'> follow</h2>
		<div class = 'whiteboard-inner2'>
		<form name='form5' method='post' action='peopleactivity.php'>
			<table>";
$num = 1;			
while($row5 = $query5->fetch_row()){
	echo"<tr>
			<td>$num.</td>
			<td><input type = 'submit' class='but-left' name = 'uname' value = '$row5[0]'></td>			
		</tr>
		<tr><td><p></p><td></tr>";
	$num = $num + 1;		
}
echo"				
			</table>
		</form>		
		</div>
	</div>
	
	<div class = 'whiteboard6'>
		<h2 align = 'center'> follow by</h2>
		<div class = 'whiteboard-inner2'>
		<form name='form5' method='post' action='peopleactivity.php'>
			<table>";
$num = 1;			
while($row6 = $query6->fetch_row()){
	echo"<tr>
			<td>$num.</td>
			<td><input type = 'submit' class='but-left' name = 'uname' value = '$row6[0]'></td>			
		</tr>
		<tr><td><p></p><td></tr>";
	$num = $num + 1;		
}
echo"				
			</table>
		</form>		
		</div>
	</div>
</body>  
</html>";
 ?>