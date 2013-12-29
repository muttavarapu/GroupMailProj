<?php require("connection.php");
if(isset($_POST['pass1']) && isset($_POST['pass2']))
{
if($_POST['pass1'] == $_POST['pass2']){$pass=$_POST['pass1'];
$email=mysql_real_escape_string($_POST['email']);
$pass=sha1($pass);
$query=mysql_query("UPDATE doctors SET `password`='$pass' WHERE email='$email'")or die("failed to enter data".mysql_error());

header("Location:login.php?msg=Your password reset successful! Login Account Now");

echo"your password for ".$_POST["email"]."Has been updated successfully <br>Login Here".$_POST['pass1'];}
else{echo "Passwords do not match!";}}
else{echo"Not works :(<br/>There is an error please request the reset  link again";}
?>