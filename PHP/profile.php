
<?php
session_start(); 
$conn = new mysqli("localhost", "root","", "db_pro2")
or die("error" . $conn->connect_error);
$username = $_SESSION['username'];
$query=$conn->query("select accountid, creditcard from accountinfo where uname='$username'");
?>
<!DOCTYPE html>  
<html lang="en">  
<style>
.postion1{
	position: absolute;   
    top: 50%;   
    left:50%;
	margin: -120px 0 0 -70px;
}

.postion2{
	position: absolute;   
    top: 50%;   
    left:50%;
	margin: -50px 0 0 -250px;
}
.postion3{
	position: absolute;   
    top: 50%;   
    left:50%;
	margin: -120px 0 0 0px;
}

.postion4{
	position: absolute;   
    top: 50%;   
    left:50%;
	margin: -50px 0 0 -180px;
}
</style>
<head>  
    <meta charset="UTF-8">  
    <title>Login</title>  
    <link rel="stylesheet" type="text/css" href="style.css"/>  
</head>  
<body>
	<div class="bg"></div>
    <div id="profile">
		<h1 class = "postion1">Profile</h1>  	
		<form class = "postion2" name="form3" method="post" action="profileupdatecheck.php"> 
			<table> 
				<tr> 
					<td ><div align="right">nickname:</div></td> 
					<td><input type="text" name="nickname"></td> 
				</tr> 
				<tr> 
					<td><div align="right">password:</div></td> 
					<td><input type="password" required="required" name="password"></td> 
				</tr> 
				<tr> 
					<td><div align="right">email:</div></td> 
					<td><input type="text" required="required" name="email"></td> 
				</tr> 
				<tr> 
					<td><div align="right">hometown:</div></td> 
					<td><input type="text" required="required" name="hometown"></td> 
				</tr> 
				<tr> 
					<td><div align="right">interest:</div></td> 
					<td><textarea name="interest" rows = '5' cols = '35'></textarea></td> 
				</tr> 
				<tr>
					<td></td>
					<td>
					<table align="left" style="margin: 8px"> 
						<tr>
							<td><button class="but" type="submit">Done</button></td> 
							<td><button class="but" type="reset">Reset</button> </td>	
						</tr> 				
					</table> 
					</td>
				</tr> 
			</table> 
		</form> 
    </div>  
    <div id="creditcard">
		<h1 class = "postion3">Creditcard</h1>  	
		<table class = "postion4" name="form4"> 
			<?php
				echo "<form method='post' action='creditcarddeletecheck.php'>";
			 	$cardno=1;
				while($row=$query->fetch_row()){
					if ($row[1]!=null){
						echo "<tr><td><div align='right'>card ".$cardno.":</div></td>
						<td><div align='center'>".$row[1]."</div></td></tr>";
						echo"<tr><td></td><td>
						<div align='right'>
							<input type='hidden' name='accountid' value=$row[0]>
							<button class='but' type='submit'>Delete</button>
						</div></td></tr>";
					$cardno++;
					}
					
				}
				echo "</form>";
			?> 
			<form method="post" action="creditcardupdatecheck.php">
				<tr>
					<td><div align="right">creditcard:</div></td> 
					<td><input type="text" required="required" name="creditcard"></td> 
				</tr>
				<tr>
					<td></td>
					<td>
					<table align="left" style="margin: 8px"> 
						<tr>
							<td><button class="but" type="submit">Add</button></td> 
							<td><button class="but" type="reset">Reset</button> </td>	
						</tr> 				
					</table> 
					</td>
				</tr>
			</form> 
		</table> 
    </div>  
</body>  
</html> 
