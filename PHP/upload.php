<?php
$conn = new mysqli("localhost", "root","", "db_pro2")
or die("error" . $conn->connect_error);
 $pid = $_POST['pid'];
 $error = $_FILES['fileField']['error'];
 $tmp_name = $_FILES['fileField']['tmp_name'];
 $size = $_FILES['fileField']['size'];
 $name = $_FILES['fileField']['name'];
 $type = $_FILES['fileField']['type'];
 if ($error == UPLOAD_ERR_OK && $size > 0) {
  $fp = fopen($tmp_name, 'r');
  $content = fread($fp, $size);
  fclose($fp);  
  $content = addslashes($content);
  $query1 = $conn->query("select * from entries where pid = '$pid' and ename = '$name'") 
  or die("SQL1 Failed");
  if($row1 = $query1->fetch_row()){
	  die("Same file name! Please change the file name and upload again!");
  }
  $query2 = $conn->query("insert into entries VALUES ('$pid', null, '$content','$name','$type')") 
  or die("SQL2 Failed");
  echo 
	"<!DOCTYPE html>  
		 <html lang='en'>
			<style>
			input:hover{
				color: #000; 
			}
			td{
				min-width:100px;
			}
			.postion{
				color:#fff;
				font-family: 'Comic Sans MS', cursive, sans-serif; 
				position: absolute;   
				top: 50%;   
				left:50%;
				margin: -100px 0 0 -200px;
			}
			</style>
			<head>  
				<meta charset='UTF-8'>  
				<title>Donate</title>  
				<link rel='stylesheet' type='text/css' href='style2.css'/>  
			</head>  
			<body> 
				<div class='bg'></div>
				<div class='postion'>  					
					<form method='post' action='project.php'>
						<input type='hidden' name='pid' value='$pid'>
						<table>					
							<tr>
								<h1>upload successfully	</h1>								
							</tr>
							<tr>
								<td></td><td><input type = 'submit' class='but-left' name = '#' value = 'back to project' style='cursor:pointer;background-color: transparent; color:#fff;'></td>
							</tr>
						</table>
					</form>
				</div>  
			</body>  
		</html>";	
}
else{
	echo" error!!!, please check the file and upload again!!!";
}

?>