<?php require_once("includes/global.php");
require("includes/functions.php");

if(isset($_GET['msg'])){$message=$_GET['msg'];}else{$message="";}
if($loggedin==1){redirect_to("index.php");
exit();}
if (isset($_POST["Forgot"]))
	{
	    // Harvest submitted e-mail address
    $email = mysql_real_escape_string($_POST["email"]);
	 
    // Check to see if a user exists with this e-mail
	$query ="SELECT `email`,'firstname' FROM doctors WHERE `email` = '$email'";
	$result = $connection->query($query) or trigger_error($mysqli->error." [$query]"); 
 if (!$result) {
    die ('There was an error running query[' . $connection->error . ']');
}
	    $userExists = $result->fetch_array();
	    if ($userExists["email"])
					{
								// Create a unique salt. This should never leave PHP unencrypted.
								//we mix this salt with user email and hash with md5
								//this link can reset passwor any time.so to add security alternatively we can also salt with date to make it expire after certain time
								$salt = "PiuwrO1#O0rl@+luH1!froe*l?8oEb!iu)_1Xaspi*(sw(^&.laBr~u3i!c?es-l651";
				 
						// Create the unique user password reset key
					$password = md5($salt . $userExists["email"]);
				 $to =$userExists['email'];
				 $to_name=$userExists['firstname'];
						// Create a url-link which we will send them to reset their password
						$pwrurl = "http://gentle-springs-9200.herokuapp.com/reset_password.php?q=" . $password."&u=".$to;
				 
						// Mail them their key
						$mailbody = "Dear user,\n\nIf this e-mail does not apply to you please ignore it. It appears that you have requested a password reset at our website Practo\n\n To reset your password, please click the link below. If you cannot click it, please paste it into your web browser's address bar.\n\n" . $pwrurl . "\n\nThanks,\n Practo Support";
					   
					   $subject  = 'Practo Password Recovery!';

					   
					   

					   
					   
					   
//swift mail settings-------------------------------------------------------->
			
			//mail server configuration

//for now we are using gmail's SMTP server to send mails
ini_set("SMTP","ssl://smtp.gmail.com");
ini_set("smtp_port","465");


//sending email from gmail requires ssl.So we enable openssl 
//also make sure you enabled ssl_module in apache server
ini_set("extension","php_openssl.dll");

require_once 'lib/swift_required.php';

// Create the Transport
$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
  ->setUsername('shri12491@gmail.com')
  ->setPassword('9908547266');

 $mailer = Swift_Mailer::newInstance($transport);

// Create a message
$message_swift = Swift_Message::newInstance($subject)
  ->setFrom(array('shri12491@gmail.com' => 'Practo Support'))
  ->setTo(array($to => 'A name'))
  ->setBody($mailbody);

// Send the message



if ($mailer->send($message_swift))
{
  $message.= "A  recovery key has been sent to your e-mail address!";
}
else
{
  $message.= "Sorry we have a problem sending mail";
}
//swift mail end------------------------------------------------------------------------>
		






		
					}
	    else
	        $message.= "No user with that e-mail address exists.";
	}


include('includes/head.php');
?>
<div class="clear"></div>
<div class="content">
<h1 id='dhead'>Request Password reset key</h1><hr/>
<div class="dbody">
<div class="form">
<?php if(!empty($message)){echo "<p>".$message."</p>";}?>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
	Please Enter Your Registered E-mail Address<br> <input type="text" name="email" size="30" placeholder="E-mail Address" /> <input type="submit" name="Forgot" value="Send Reset Code" />
	</form></div>
</div>
</div>



<?php include('includes/foter.php');
$connection->close();?>


</body></html>