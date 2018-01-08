<?php 
function checkstr($str) {
	if (inject_check ($str)) {
		die ( 'illegal argument' );
	}
	$str = str_replace ( "_", "\_", $str );
	$str = str_replace ( "%", "\%", $str );
	$str = htmlspecialchars ( $str );
	return $str;
}

function inject_check($sql_str) {
	return eregi ( 'select|inert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|UNION|into|load_file|outfile', $sql_str );

}

$conn = new mysqli("localhost", "root","", "db_pro2")
or die("error" . $conn->connect_error);

session_start();
$username=$_SESSION["username"];
$upassword=$_POST["password"];
$loginname=$_POST["nickname"];
$email=$_POST["email"];
$hometown=$_POST["hometown"];
$interest=$_POST["interest"];

if($interest==""){
	$conn->query("update users set upassword='$upassword',loginname='$loginname', email='$email',hometown='$hometown' where uname='$username'");
}else{
	$conn->query("update users set upassword='$upassword',loginname='$loginname', email='$email',hometown='$hometown',interest='$interest' where uname='$username'");
}
header("Location:main.php");
?>