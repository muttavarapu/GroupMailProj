<?php require_once("global.php");require("includes/functions.php");
if($loggedin==0){header("Location:login.php");
exit();}

//message submit form handling-------------------------------------->
if(isset($_POST['sendMail'])){

//catch submitted values
$message_body=mysql_real_escape_string($_POST['body']);
$subj=mysql_real_escape_string($_POST['subj']);
$recipients=$_POST['check_list'];



//to enable patients to reply directly doctor's mail,we will send the doctors mail in the (reply to) email header

//we need to get the doctors mail from doctors database


$query="SELECT email, firstname, lastname  FROM doctors WHERE id={$session_id}";
$result = $connection->query($query) or trigger_error($mysqli->error." [$query]");
if (!$result) {
    die ('There was an error running query[' . $connection->error . ']');
}

while($row=$result->fetch_array()){$replyto=$row[0];
$doc_name= "Dr. ".$row[1]." ".$row[2];}

		/*    using Swift mailer to send mail
		      include lib folder from Swiftmail package inside the project
              include swift mail                                                             */

			  require_once '../lib/swift_required.php';

//mail server configuration

//for now we are using gmail's SMTP server to send mails
ini_set("SMTP","ssl://smtp.gmail.com");
ini_set("smtp_port","465");


//sending email from gmail requires ssl.
//So we need to enable openssl 
//also make sure you enabled ssl_module in apache server
ini_set("extension","php_openssl.dll");

// Create the Transport
//set the username and password of the email through which mails were to be sent
$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
  ->setUsername('shri12491@gmail.com')
  ->setPassword('9908547266')
  ;
 $mailer = Swift_Mailer::newInstance($transport);

// Create a message
$message = Swift_Message::newInstance($subj)
  ->setFrom(array('shri12491@gmail.com' => $doc_name))
  ->setReplyTo(array($replyto => $doc_name))
  ->setBody($message_body)
  ;


$to = array($recipients);


//initialize empty array's to catch the failed and sucessful recipients
$failedRecipients = array();
$sucessRecipients =array();

// Sending the message the message------------------------------------------------>
			foreach ($to as $address => $name)
			{
						//check if the array key is int
						//i.e, if the address stored as 0=>mail or mail=> name
						//we can show name of the recipient(in gmail) if we store as mail=>name inside array
		
			//for array stored as 0=>mail	 
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
			  //for array element stored as mail=>name
				$message->setTo(array($address => $name));
				if (!$mailer->send($message, $failures))
				{
					$failedRecipients[]=$name;
				}else{
				$sucessRecipients[]=$name;
				}
			  }
}
//Message sent.Swift mail configuration  ends---------------------------------------------------->


//store the successful recipients and message into database

if(count($sucessRecipients) > 0)
					{
					$sucess=$sucessRecipients[0];
       //store the email of successful recipients in  an array
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
					
					
					$query="INSERT INTO messages(d_id,message,recipients,sent_on,ip_address,subject) VALUES('$session_id','$message_body','$insert',now(),'$ip_address','$subj')";
					//catch insert id to display sent message 
					$result = $connection->query($query) or trigger_error($mysqli->error." [$query]");
					
					if (!$result) {
    die ('There was an error running query[' . $connection->error . ']');
}
					$msg_id=$connection->insert_id;
					$msg[]="<p class='sucess'>Message Sucessfully sent to ".$count." Recipients!</p>";

					}
else{//This means no email is sent
    $msg[]= "<p class='error'>Email sending failed</p>";}

//display failed recipients
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

}


//form handling ends

			
if(isset($_GET['msg'])){$msg[]=$_GET['msg'];}


//check if logged in
if($session_id){
//if message sending is a sucess display that message
if(isset($msg_id)){$id=$msg_id;}

//displaying requested message message
//to show a specific message as per uri
elseif(isset($_GET['id'])){$id=$_GET['id'];}
else{
$goto ='messages.php?msg=click on a message to view';
redirect_to($goto);
}
$query="SELECT id,subject,message AS body,sent_on,recipients FROM messages WHERE d_id='$session_id' AND id='$id' LIMIT 1";
$result = $connection->query($query) or trigger_error($mysqli->error." [$query]");
if (!$result) {
    die ('There was an error running query[' . $connection->error . ']');
}
$output="<p class='error'>Cannot load Requested Message</p>";
while($row=$result->fetch_array()){

$output= "<div class='msg'><h2 class='subj'>".$row['subject']."</h2><h2 class='date'>".$row['sent_on']."</h2><div class='clear'></div><p class='msgBody'>".$row['body']."</p><br/><p>Recipents: ".$row['recipients']."</p></div>";
}
}
else{redirect_to('login.php?msg="Could not check your data <br/>error please login again!"');}



include('includes/head.php');



?>


<div class="clear"></div>
<div class="content">
<h1 id="dhead">View Message</h1><hr/>
<div class="dbody">
<?php if(!empty($msg)){foreach($msg as $msg){echo $msg."<br/>";}}
echo $output;

?>
</div>
</div>



<?php include('includes/foter.php');$connection->close();?>


</body></html>