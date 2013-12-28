<?php 
require_once("global.php");
require("includes/functions.php");
if($loggedin ==1){redirect_to('home.php?msg=<p class="suces">you are already loggedin!</p>');}
if(isset($_POST['username'])){ 
$username=$_POST['username'];
$lname=$_POST['lname'];
$fname=$_POST['fname'];
$pass1=$_POST['pass1'];
$pass2=$_POST['pass2'];$email=$_POST['email'];
//error handling
if((!$username)||(!$fname)||(!$lname)||(!$pass1)||(!$pass2)||(!$email)){$message[]="Please insert all requires fields in the registration form";}
if(!preg_match('/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/', $email)){ //validate email address - check if is a valid email address
			$email="";
			$message[] = "You have entered an invalid email address!";
	}
if($pass1!=$pass2){$message[]="Passwords do not  Match";}
if(strlen($pass1) <=5 ){$message[]="Passwords should be more than 5chars long";}
//error handling stops



$username=preg_replace("#[^0-9a-z]#i","",$username);
$lname=preg_replace("#[^0-9a-z]#i","",$lname);
$fname=preg_replace("#[^0-9a-z]#i","",$fname);
$pass1=sha1($pass1);
$email=mysql_real_escape_string($email);
$user_query=mysql_query("SELECT username FROM doctors WHERE username='$username' LIMIT 1")or die("Could not check for usernames error with connection");
$count_username=mysql_num_rows($user_query);
$email_query=mysql_query("SELECT email FROM doctors WHERE email='$email' LIMIT 1")or die("Could not check for usernames error with connection");
$count_email=mysql_num_rows($email_query);
if($count_username > 0){$message[]="Username already taken";}
else if($count_email > 0){$message[]="The mail you provided is already registerd with us ";}


if(empty($message)){
//form processing starts
$ip_address=$_SERVER['REMOTE_ADDR'];
$query=mysql_query("INSERT INTO doctors(username,firstname,lastname,email,password,ip_address,signupdate,lastlogged) VALUES('$username','$fname','$lname','$email','$pass1','$ip_address',now(),now())")or die("failed to enter data".mysql_error());
$member_id=mysql_insert_id();
mkdir("users/$member_id",0755);
$msg="<p class='sucess'>Yay! You have been registered. Now you can login to your account!</p>";
$goto ='login.php?msg='.$msg;
redirect_to($goto);
}



}


?>


<?php include('includes/head.php');?>
<div class="clear"></div>
<div class="content">
<h1 id='dhead'>Register to Tutoscoop  |  The free tutorial place Just a Click away!</h1><hr><div class="dbody">
<?php if(!empty($message)){foreach($message as $msg){echo "<p class='error'>".$msg."</p>";}}?>
</hr><form action="register.php" method="post">
<input type="text" name="username" size=15 maxlength=15 <?php if(!empty($username)){echo 'value="'.$username.'"';}?> placeholder="Username"/></br>

<input type="text" name="fname" size=25 maxlength=25 <?php if(!empty($fname)){echo 'value="'.$fname.'"';}?> placeholder="Firstname"/></br>

<input type="text" name="lname" size=25 maxlength=25 <?php if(!empty($lname)){echo 'value="'.$lname.'"';}?> placeholder="Lastname"/></br>

<input type="text" name="email" size=25 <?php if(!empty($email)){echo 'value="'.$email.'"';}?> placeholder="Email Address"/></br>

<input type="password" name="pass1" size=25 placeholder="Password"/></br>
<input type="password" name="pass2" size=25 placeholder="Validate Password"/></br>
<input type="submit" value="Register!"/>

</form>
</div></div>





<?php include('includes/foter.php');?>

</body></html>
<?php mysql_close($connection);?>