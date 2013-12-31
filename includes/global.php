<?php session_start();
include_once("connection.php");
//check if session is set
if(isset($_SESSION['username'])){
				$session_username=$_SESSION['username'];
				$session_pass=$_SESSION['pass'];
				$session_id=$_SESSION['id'];
				//check member data
				$query="SELECT * FROM doctors WHERE id='$session_id' AND password='$session_pass' LIMIT 1";
				$result = $connection->query($query);
				if (!$result) {
    die ('There was an error running query[' . $connection->error . ']');
}
				$count_count=mysqli_num_rows($result);
				if($count_count > 0){
						while($row=$result->fetch_array()){$session_username=$row['username'];}
						$_SESSION['id']=$session_id;
						$_SESSION['username']=$session_username;
						$_SESSION['pass']=$session_pass;
						$loggedin=1;}
				else{
				header("Location:login.php");
				exit(); 
				}
}
elseif(isset($_COOKIE['id_cookie'])){
$session_id=$_COOKIE['id_cookie'];
$session_pass=$_COOKIE['pass_cookie'];
$query="SELECT * FROM doctors WHERE id='$session_id' AND password='$session_pass' LIMIT 1";
if (!$result = $connection->query($query)) {
    die ('There was an error running query[' . $connection->error . ']');
}


$count_count=mysqli_num_rows($query);
if($count_count > 0){$loggedin=1;}
else{
header("Location:login.php");
exit(); 
}
}

else{$loggedin=0;}


?>