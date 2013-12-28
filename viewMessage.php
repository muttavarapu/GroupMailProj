<?php require_once("global.php");require("includes/functions.php");
if($loggedin==0){header("Location:login.php");
exit();}

//message submit form handling----------->
if(isset($_POST['sendMail'])){

$message=mysql_real_escape_string($_POST['body']);
$subj=mysql_real_escape_string($_POST['subj']);
$recipients=$_post['checklist'];
//to enable patients to reply directly doctor's mail,we will send the doctors mail in the email header(reply to)
//get the doctors mail from doctors database


$query=mysql_query("SELECT email, firstname, lastname  FROM doctors WHERE id={$session_id}") or die("could not connect to database".mysql_error());
$replyto= mysql_fetch_array($query)[0];
$doc_name= "Dr. ".mysql_fetch_array($query)[1]." ".mysql_fetch_array($query)[2];

// using Swift mailer to send mail
// include lib folder from swiftmail package inside the project

//mail server configuration
//for this we are using gmail SMTP server
ini_set("SMTP","ssl://smtp.gmail.com");
ini_set("smtp_port","465");
//sending email from gmail reqires ssl.So we enable openssl 
//also make sure you enabled ssl_module in apache server
ini_set("extension","php_openssl.dll");
// include swift mail
require_once '../lib/swift_required.php';
// Create the Transport
//set the username and password of the email through which mails were to be sent
$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
  ->setUsername('shri12491@gmail.com')
  ->setPassword('9908547266')
  ;




 $doc_name="Doc Puk";
 $mailer = Swift_Mailer::newInstance($transport);

// Create a message
$message = Swift_Message::newInstance($subj)
  ->setFrom(array('shri12491@gmail.com' => $doc_name))
  ->setReplyTo(array($replyto => $doc_name))
  ->setBody($message)
  ;

// Send the message


$to = array($recipients);
$failedRecipients = array();
	$sucessRecipients =array();
foreach ($to as $address => $name)
{//check if the array ket is int 
//i.e, if the address stored as 0=>mail or mail=> name
  if (is_int($address)) {
    $message->setTo($name);
	if (!$mailer->send($message, $failures))
	{//catch the sucessful recipients
		$failedRecipients[]=$name;
	}else{
	//failed recipents
	$sucessRecipients[]=$name;
	}
  } 
  else {
    $message->setTo(array($address => $name));
	if (!$mailer->send($message, $failures))
	{
		$failedRecipients[]=$name;
	}else{
	$sucessRecipients[]=$name;
	}
  }
}



//
if(count($failedRecipients) > 0)
{
$failed=$failedRecipients[0];
foreach ($failed as $address => $name)
{if (is_int($address)) {
    $fail[]= $name;
	  
  } 
  else {
    $fail[]= $address;
  }

}
$fail=implode(",",$fail);
$msg[]="<p class='error'>Cant sent email to ".$fail."</p>";
}

if(count($sucessRecipients) > 0)
{
$sucess=$sucessRecipients[0];

foreach($sucess as $address => $name){
if (is_int($address)) {
    $insert[]= $name;
	
  } 
  else {$insert[]= $address;
    
  }
}
$count=count($insert);
$insert=implode(",",$insert);
$insert=mysql_real_escape_string($insert);

$ip_address=$_SERVER['REMOTE_ADDR'];
$query=mysql_query("INSERT INTO messages(d_id,message,recipients,sent_on,ip_address,subject) VALUES('$session_id','$message','$insert',now(),'$ip_address','$subj')")or die("failed to enter data".mysql_error());
$msg_id=mysql_insert_id();
$msg[]="<p class='sucess'>Message Sucessfully sent to ".$count."Recipients!</p>";

}
else{
    $msg[]= "<p class='error'>Email sending failed</p>";}


//$goto ='messages.php?msg='.$msg.$to;
//redirect_to($goto);
}




			







if(isset($_GET['msg'])){$msg[]=$_GET['msg'];}
if($session_id){
if(isset($msg_id)){$id=$msg_id;}
elseif(isset($_GET['id'])){$id=$_GET['id'];}else{
//$goto ='messages.php?msg=';
//redirect_to($goto);
}
$query=mysql_query("SELECT id,subject,message AS body,sent_on,recipients FROM messages WHERE d_id='$session_id' AND id='$id' LIMIT 1") or die("Could not check the session".mysql_error());}
else{redirect_to('login.php?msg="error please login again!"');}
include('includes/head.php');
?>
<div class="clear"></div>
<div class="content">
<h1 id="dhead">Sent Messages</h1><hr/>
<div class="dbody">
<?php if(!empty($msg)){foreach($msg as $msg){echo $msg."<br/>";}}
while($row=mysql_fetch_array($query)){

echo "<div class='msg'><h2 class='subj'>".$row['subject']."</h2><h2 class='date'>".$row['sent_on']."</h2><div class='clear'></div><p class='msgBody'>".$row['body']."</p><br/><p>Recipents: ".$row['recipients']."</p></div>";
}

?>
</div>
</div>



<?php include('includes/foter.php');?>


</body></html><?php mysql_close($connection);?>