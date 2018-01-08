<?php
session_start(); 
$conn = new mysqli("localhost", "root","", "db_pro2")
or die("error" . $conn->connect_error);
$username = $_SESSION['username'];
$pid=$_POST['pid'];

$query11=$conn->query("insert into searchedprojects values('$username','$pid',default)") or die("SQL-11 Failed");
$query0=$conn->query("select distinct tag from tags join searchedprojects on tags.pid=searchedprojects.pid where tags.pid='$pid'")or die("SQL0 Failed");

while($row=mysqli_fetch_assoc($query0)){
		$tag=$row["tag"];
		$conn->query("insert into searchedtags values('$username','$tag',default)")or die("SQL0 Failed");}

$query1 = $conn->query("select pname,powner,description, starttime, pstatus from projects where pid = '$pid'")
or die("SQL1 Failed");
$row1 = $query1->fetch_row();

$query11 = $conn->query("select count(*) from comments c join projects p on c.pid = p.pid where p.pid = '$pid'")
or die("SQL11 Failed");
$row11 = $query11->fetch_row();

$query2 = $conn->query("select tag from tags natural join projects where pid = $pid")
or die("SQL2 Failed");

$query3 = $conn->query("select sum(money) from fund f join projects p on f.pid = p.pid where p.pid = '$pid'")
or die("SQL3 Failed");

$query4 = $conn->query("select accountid, creditcard from accountinfo where uname = '$username' and creditcard is not null")
or die("SQL4 Failed");

$query5 = $conn->query("select c.uname, c.posttime, c.comments from comments c join projects p on c.pid = p.pid where p.pid = '$pid' ")
or die("SQL5 Failed");

$query6 = $conn->query("select a.uname,f.money, f.starttime, f.fstatus from fund f 
																		join accountinfo a on f.accountid = a.accountid
																		join projects p on f.pid = p.pid 
																		where p.pid = '$pid'")
or die("SQL6 Failed");

$query7 = $conn->query("select ename, posttime from entries where pid = '$pid'")
or die("SQL7 Failed");

$query8 = $conn->query("select * from fund f join accountinfo a on f.accountid = a.accountid where f.pid = '$pid' and a.uname = '$username'")
or die("SQL8 Failed");
$row8 = $query8->fetch_row();

$query9 = $conn->query("select * from stars where pid = '$pid' and uname = '$username'")
or die("SQL9 Failed");
$row9 = $query9->fetch_row();

$query10 = $conn->query("select avg(star) from stars where pid = '$pid'")
or die("SQL10 Failed");
$row10 = $query10->fetch_row();

echo"<!DOCTYPE html>  
<html lang='en'>  
<head>    
    <meta charset='UTF-8'>  
    <title>project</title>  
    <link rel='stylesheet' type='text/css' href='style2.css'/>  
</head>  
<body> 
	<div class='bg'></div>
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
		<p align= 'center' style ='font-size:35px;color:#000;'>
			$row1[0]
		</p>
		<div class = 'board1position2'>
			<form action='peopleactivity.php' method='post'>
				<table>
					<tr>
						<td>Owner: </td>
						<td><input type = 'submit' class='but-left' name = 'uname' value = '$row1[1]'/></td>
						<td>, Likes: $row11[0]</td>
					</tr>
				</table>
			</form>
		</div>
														
		<div class = 'smallboard'>$row1[2]</div>
		<p align= 'center' class = 'board1position4' style ='font-size:20px;color:#000;'>Tags:&nbsp";															
while($row2 = $query2->fetch_row()){
	echo"$row2[0]&nbsp&nbsp&nbsp";	
}

echo"	</p>";
if($row1[4] == 'finish'){
	echo"<p align= 'center' class = 'board1position5' style ='font-size:20px;color:#000;'>stars:&nbsp $row10[0]</p>";
}															
echo"	</div>";

	
$row3 = $query3->fetch_row();	
if($row1[3] == null){	
	echo"
		<div class = 'whiteboard2'>
		<form action='donatecheck.php' method='post'> 
			<input type='hidden' name='pid' value='$pid'/>
			<p class = 'board2position0'style ='font-size:30px;
												color:#000;	
												font-weight:bold;'>Now:&nbsp$$row3[0]</p>
			<p class='headline board2position1'>Enter your donation</p>
			<div class='dollarsign'>$</div>
				<input autocomplete='off' class='donationamount' 
					id='input_amount' maxlength='5' name='donationAmount' 
					style='z-index:1;' tabindex='1' type='text' value=''/>
			<p class='headline board2position2'>Select your creditcard</p>	 
			<select class = 'board2position3' name='creditcard'> 
				<table>
					<tr>
						<td><option name = 'creditcard' value=''></option></td>				
					</tr>";
	$num = 1;			
	while($row4 = $query4->fetch_row()){
		echo"
			<tr>
				<td>$num.</td>
				<td><option name = 'creditcard' value='$row4[0]'>$row4[1]</option></td>				
			</tr>
			<tr><td><p></p><td></tr>";
		$num = $num + 1;		
	}
	echo"				
				</table>		
			</select>
			<button class='but board2position4' type='submit'>donate</button>	
		</form>  
	</div>";
}
else{
	echo"
		<div class = 'whiteboard2'>
			<p class = 'board2position0'style ='font-size:30px;
												color:#000;	
												font-weight:bold;'>attachment:</p>
			<div class = 'board2position5'>
				<table>";
	$num = 1;		
	while($row7 = $query7->fetch_row()){	
		echo
		"
		<tr>
			<td>$num.&nbsp</td>
			<td>
				<form method='post' action='fetchfile.php'>
					<input type='hidden' name='pid' value='$pid'/>
					<input type = 'submit' class='but-left' name = 'ename' value = $row7[0]>
				</form>
			</td>			
			<td><p class='but-middle'>$row7[1]</p></td>
		</tr>
		<tr><td><p></p></td></tr>
		";
		$num = $num + 1;
	}	
	echo"		</table>
			</div>";	
	if($row1[1] == $username){
		echo"
			<div class = 'board2position6'>
				<form method='post' action='upload.php' enctype='multipart/form-data'>
						<input type='hidden' name='pid' value='$pid'>
						<input type='text' name='textfield' id='textfield' class='txt' value=''>  
						<input type='button' class='btn' value='files'>
						<input type='file' name='fileField' class='file' id='fileField' size='28' onchange='document.getElementById(&quot;textfield&quot;).value=this.value'>
						<input type='submit' name='submit' class='btn' value='upload'>
				</form>
			</div>";
}
	echo"</div>";
}



echo"	
	<div class = 'whiteboard3'>
		<p align= 'center' class = 'board3position1'	style ='font-size:30px;
															color:#000;'>comment</p>
		<form class = 'board3position2' method='post' action='commentcheck.php'>
			<div>
				<input type='hidden' name='pid' value='$pid'/>
				<textarea rows = '8' cols = '65' name = 'comment'>please input you comment</textarea>
				<p class='board3position3'>
					<input type='radio' name='iflike' value='like' checked='checked'/>like  
					<input type='radio' name='iflike' value='dont' />dont like 
				</p>
				<button class='but1 board3position4' type='submit'>submit</button>
			</div>
		</form>";
		
if($row1[4] == 'finish' && $row8 && !$row9){
echo"	<form class = 'board3position5' method='post' action='starcheck.php'>
			<div>
				<input type='hidden' name='pid' value='$pid'>
				<table><tr>					
					<td><input type='radio' name='star' value='1'/>1	</td>	
					<td><input type='radio' name='star' value='2'/>2	</td>	
					<td><input type='radio' name='star' value='3'/>3	</td>	
					<td><input type='radio' name='star' value='4'/>4	</td>	
					<td><input type='radio' name='star' value='5'/>5	</td>					
					<td><button class='but1' type='submit'>star</button></td>
				</table></tr>
			</div>
		</form>";
}
echo"
		<div class = 'whiteboard-inner1'>
			<form method='post' action='peopleactivity.php'>
				<table>";

$num = 1;			
while($row5 = $query5->fetch_row()){
	$row5[2] = htmlspecialchars ($row5[2]);
	echo"<tr>
			<td>$num.</td>
			<td><input type = 'submit' class='but-left' name = 'uname' value = '$row5[0]'/></td>	
			<td><p class='but-middle'>$row5[1]</p></td>
			<td><p class='but-right'>$row5[2]</p></td>			
		</tr>
		<tr><td><p></p><td></tr>";
	$num = $num + 1;		
}

echo"				
				</table>
		</form>		
		</div>
	</div>

	
	
	<div class = 'whiteboard4'>
		<p align= 'center' class = 'board4position1' style ='font-size:30px;color:#000;'>recent donation</p>
		<div class = 'whiteboard-inner2'>
		<form method='post' action='peopleactivity.php'>
			<table>";

$num = 1;			
while($row6 = $query6->fetch_row()){
	echo"<tr>
			<td>&nbsp$num.</td>
			<td><input type = 'submit' class='but-left' name = 'uname' value = '$row6[0]'/></td>	
			<td><p class='but-middle'>$$row6[1]</p></td>
			<td><p class='but-right'>$row6[2]</p></td>				
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
</html>" 
?> 