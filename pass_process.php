<?php require("connection.php");
if(isset($_POST['pass1']) && isset($_POST['pass2']))
{
			if($_POST['pass1'] == $_POST['pass2']){
			$pass=$_POST['pass1'];
			$email=mysql_real_escape_string($_POST['email']);
			$pass=sha1($pass);
			$query="UPDATE doctors SET `password`='$pass' WHERE email='$email'";
			$result = $connection->query($query) or trigger_error($mysqli->error." [$query]"); 
			 if (!$result) {
				die ('There was an error running query[' . $connection->error . ']');
			}
			header("Location:login.php?msg=Your password reset successful! Login Account Now");

			echo"your password for ".$_POST["email"]."Has been updated successfully <br>Login Here".$_POST['pass1'];}
			else{echo "Passwords do not match!";}
			
			
			}
else{echo"Not works :(<br/>Sorry you are not allowed to resect";}

$connection->close();
?>