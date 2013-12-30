<?php require_once("global.php");
require("includes/functions.php");
if($loggedin ==1){redirect_to('home.php');}
else{
if(isset($_GET['msg'])){$message=$_GET['msg'];}
if(isset($_POST['email'])){
	$email=$_POST['email'];
	$pass=$_POST['pass'];
	$remember=$_POST['remember'];
		if((!$email) ||(!$pass)){$message='please insert both password and email!';}
	else{
				$email=mysql_real_escape_string($email);
			$pass=sha1($pass);
			$query=mysql_query("SELECT * FROM doctors WHERE (email='$email' OR username='$email') AND password='$pass' LIMIT 1") or die("could not find the member");
			$count_query=mysql_num_rows($query);
			if($count_query==0){$message="The information you entered was incorrect";}
			else{
					$_SESSION['pass']=$pass;
					while($row=mysql_fetch_array($query)){$username=$row['username'];
					$id=$row['id'];}
					$_SESSION['username']=$username;
					$_SESSION['id']=$id;
					if($remember=="yes"){setcookie("id_cookie",$id,time()+60*60*24*100,"/");
					setcookie("username_cookie",$username,time()+60*60*24*100,"/");
					setcookie("pass_cookie",$pass,time()+60*60*24*100,"/");}
					$query=mysql_query("UPDATE doctors SET `lastlogged`=NOW() WHERE username='$username'")or die("failed to enter data".mysql_error());
					redirect_to("home.php");

			}
	}


}}


include('includes/head.php');
?>

<div class="clear"></div>
<div class="content">
<h1 id='dhead'>Register to Tutoscoop  |  The free tutorial place Just a Click away!</h1><hr/><div class="dbody">
<?php if(!empty($message)){echo "<p>".$message."</p>";}?>
</hr><form action="login.php" method="post">
<input type="text" name="email" placeholder="Email Address"/></br>
<input type="password" name="pass" placeholder="Password"/></br>
<input type="checkbox" name="remember" value="yes" checked="checked" placeholder="remember"/>Remember</br>
<input type="submit" value="Login!"/>
<a href="">Forgot Password</a>

</form>
</div>

</div>


<?php include('includes/foter.php');?>

</body></html><?php mysql_close($connection);?>