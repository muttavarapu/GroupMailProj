<?php
require_once("global.php");
require("includes/functions.php");
if(isset($_GET['u']) && $_GET['q']){
$salt = "PiuwrO1#O0rl@+luH1!froe*l?8oEb!iu)_1Xaspi*(sw(^&.laBr~u3i!c?es-l651";
$salt.=$_GET['u'];
$pass= md5($salt);
if($_GET['q']==$pass){
$out= "Now you can reset password for ".$_GET['u'].'<br>
<form action="pass_process.php" method="POST">
<input type="text" name="email" value="'.$_GET['u'].'" size=25 READONLY /><br><input type="password" name="pass1" size=25 placeholder="Password"/></br>
<input type="password" name="pass2" size=25 placeholder="Validate Password"/></br><input type="submit" name="submit" value="Register!"/></form>';

}
else{$out= "Wrong verification!.Request reset link to your email address again";}

}elseif($loggedin==1){
$userEmail = mysql_fetch_assoc(mysql_query("SELECT `email` FROM doctors WHERE `id` = '$session_id'"));
$out= "Now you can reset password for ".$userEmail['email'].'<br>
<form action="pass_process.php" method="POST">
<input type="text" name="email" value="'.$userEmail['email'].'" size=25 READONLY /><br><input type="password" name="pass1" size=25 placeholder="Password"/></br>
<input type="password" name="pass2" size=25 placeholder="Validate Password"/></br><input type="submit" name="submit" value="Register!"/></form>';} 

else{echo "<h1>Hey you!</h1> <br/>Why are you are sneaking here without authentication!<br>go back to <a href='login.php'>login</a> page and come with authentication";}

?>
<html>
<head><title>Reset Password</title>
</head><body>
<?php if(!empty($out)){echo $out;} ?>
</body>

</html>