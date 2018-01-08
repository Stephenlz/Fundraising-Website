<?php 
function checkstr($str) {
	if (inject_check ($str)) {
		die ( 'illegal argument' );
	}
	$str = str_replace ( "_", "\_", $str );
	//把"_"过滤掉
	$str = str_replace ( "%", "\%", $str );
	//把"%"过滤掉
	$str = htmlspecialchars ( $str );
	//转换html
	return $str;
}

function inject_check($sql_str) {
	return eregi ( 'select|inert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|UNION|into|load_file|outfile', $sql_str );
	// 进行过滤，防注入
}

$conn = new mysqli("localhost", "root","", "db_pro2")
or die("error" . $conn->connect_error);


$username = $_POST['username']; 
$password = $_POST['password'];
$username = checkstr($username);
$password = md5($password);

$query = $conn->query("select upassword from users where uname = '$username'") 
or die("SQL Failed"); 
if($row = $query->fetch_row()){	
	if($password == $row[0]){
		session_start(); 
		$_SESSION['username'] = $username; 
		header("Location:main.php"); 
	}
	else{ 
		echo "this user doesn't exist!"; 
	}
} 
 
?>