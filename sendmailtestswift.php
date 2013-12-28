<?php
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
require_once 'lib/swift_required.php';
// Create the Transport
//set the username and passord of the email through which mails were to be sent
$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
  ->setUsername('shri12491@gmail.com')
  ->setPassword('9908547266')
  ;
$recipients[]="shri.nitsri@gmail.com";
$recipients[]="shrikanth.nits@gmail.com";
$recipients['shri122491@55.com']="mutthavarapu!!";
$recipients['srikanth12491@5.com']="Saikrishhhh";

/*


// Create a message
$message = Swift_Message::newInstance('Wonderful Subject')
  ->setFrom(array('shri12491@gmail.com' => 'Practo Doctor'))
  ->setTo($recipients)
  ->setBody('Here is the message itself')
  ;

// Send the message
if (!$mailer->send($message, $failures))
{
  echo "Failures:";
  print_r($failures);
}*/
 
 $replyto="dfsdf@hggh.com";
 $doc_name="Doc Puk";
 $mailer = Swift_Mailer::newInstance($transport);

// Create a message
$message = Swift_Message::newInstance('This should be recieved independently! With reply to option')
  ->setFrom(array('shri12491@gmail.com' => 'Practo'))
  ->setReplyTo(array($replyto => $doc_name))
  ->setBody('Here is the message itself')
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
echo $insert;
}
echo "Sucess Recipients";

$sucess=$sucessRecipients[0];

foreach($sucess as $address => $name){
if (is_int($address)) {
    $insert[]= $name;
	
  } 
  else {$insert[]= $address;
    
  }
}
$insert=implode(",",$insert);
echo $insert;

?>