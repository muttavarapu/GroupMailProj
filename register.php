<?php 
require_once("includes/global.php");
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
//check if username and mail are already registered

$user_query="SELECT username FROM doctors WHERE username='$username' LIMIT 1";
		$result_uName = $connection->query($user_query)or trigger_error($mysqli->error." [$query]");;
			if (!$result_uName) {
    die ('There was an error running query[' . $connection->error . ']');
}
	$count_username=mysqli_num_rows($result_uName);
	$email_query="SELECT email FROM doctors WHERE email='$email' LIMIT 1";
	
		$result_uEmail = $connection->query($user_query)or trigger_error($mysqli->error." [$query]");;
			if (!$result_uEmail) {
    die ('There was an error running query[' . $connection->error . ']');
}
$count_email=mysqli_num_rows($result_uEmail);


if($count_username > 0){$message[]="Username already taken";}
else if($count_email > 0){$message[]="The mail you provided is already registerd with us ";}


if(empty($message)){
//form processing starts
$ip_address=$_SERVER['REMOTE_ADDR'];

$query="INSERT INTO doctors(username,firstname,lastname,email,password,ip_address,signupdate,lastlogged) VALUES('$username','$fname','$lname','$email','$pass1','$ip_address',now(),now())";

		$result = $connection->query($user_query)or trigger_error($mysqli->error." [$query]");;
			if (!$result) {
    die ('There was an error running query[' . $connection->error . ']');
}
$member_id=$connection->insert_id;
mkdir("users/$member_id",0755);
$msg="<p class='sucess'>Yay! You have been registered. Now you can login to your account!</p>";
$goto ='login.php?msg='.$msg;
redirect_to($goto);
}



}


?>


<?php include('includes/head.php');?>

<script>
function validateForm()
{
var x=document.forms["register"]["pass1"].value;
var y=document.forms["register"]["pass2"].value;
if (x==null || x=="")
  {
  alert("Confirm Password");
  return false;
  }
  else if (y==null || y=="")
  {
  alert("Enter Password");
  return false;
  }else if(!(x==y)){
  alert("Passwords Do not Match");
  return false;
  }else{return true;
  }
}
function usercheck(str)
{
var xmlhttp;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("write").innerHTML=xmlhttp.responseText;
	
    }
  }
xmlhttp.open("GET","includes/usercheck.php?q="+str,true);
xmlhttp.send();
}
function mailcheck(str)
{
var xmlhttp;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("mail").innerHTML=xmlhttp.responseText;
	
    }
  }
xmlhttp.open("GET","includes/mailcheck.php?q="+str,true);
xmlhttp.send();
}</script>
<div class="clear"></div>
<div class="content">
<h1 id='dhead'>Register to Tutoscoop  |  The free tutorial place Just a Click away!</h1><hr><div class="dbody">
<?php if(!empty($message)){foreach($message as $msg){echo "<p class='error'>".$msg."</p>";}}?>
</hr><form action="register.php" method="post" name="register" onsubmit="return validateForm()" >
<input type="text" name="username" onkeyup="usercheck(this.value)" size=15 maxlength=15 <?php if(!empty($username)){echo 'value="'.$username.'"';}?> placeholder="Username"/><span id="write"></span></br>

<input type="text" name="fname" size=25 maxlength=25 <?php if(!empty($fname)){echo 'value="'.$fname.'"';}?> placeholder="Firstname"/></br>

<input type="text" name="lname" size=25 maxlength=25 <?php if(!empty($lname)){echo 'value="'.$lname.'"';}?> placeholder="Lastname"/></br>

<input type="text" name="email" onkeyup="mailcheck(this.value)" size=25 <?php if(!empty($email)){echo 'value="'.$email.'"';}?> placeholder="Email Address"/><span id="mail">
</span></br>

<input type="password" name="pass1" size=25 placeholder="Password"/></br>
<input type="password" name="pass2" size=25 placeholder="Validate Password"/></br>
<input type="submit" value="Register!"/>

</form>
</div></div>





<?php include('includes/foter.php');
$connection->close();?>

</body></html>
