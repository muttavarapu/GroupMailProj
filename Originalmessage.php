<?php require_once("global.php");require("includes/functions.php");
if($loggedin==0){header("Location:login.php");
exit();}?><?php 
$recipients=0;


//self submit form handling----------->
if(isset($_POST['sendMail'])){

$message=mysql_real_escape_string($_POST['body']);
$subj=mysql_real_escape_string($_POST['subj']);
foreach($_POST['check_list'] as $check) {
$check=trim($check);
$to_emails[]=$check;
}
//to enable patients to reply directly doctor's mail,we will send the doctors mail in the email header(reply to)
//get the doctors mail from doctors database


$query=mysql_query("SELECT email FROM doctors WHERE id={$session_id}") or die("could not connect to database".mysql_error());
$reply_mail= mysql_fetch_array($query)[0];


//make a comma separated string of to emails from recipients array
$to_emails=implode(",",$to_emails);
$to=$to_emails;
$headers  = 'From: '.$reply_mail.'' . "\r\n" .
            'Reply-To: '.$reply_mail.'' . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
			
if(mail($to, $subj, $message, $headers)){
    $ip_address=$_SERVER['REMOTE_ADDR'];
$query=mysql_query("INSERT INTO messages(d_id,message,recipients,sent_on,ip_address,subject) VALUES('$session_id','$message','$recipients',now(),'$ip_address','$subj')")or die("failed to enter data".mysql_error());
$msg_id=mysql_insert_id();
$msg="<p class='sucess'>Message Sucessfully sent!</p>";
$goto ='messages.php?msg='.$msg.$to;
redirect_to($goto);}
else{
    $msg[]= "Email sending failed";}



}

//handling form submitted from patients.php------------->
if(isset($_POST['message'])){


//Checking credentials of selected patients------------------>
if(!empty($_POST['check_list'])) {
 //grab the patient data from api
 $json = file_get_contents('http://localhost/Practo/patients.js');
 //$json = file_get_contents('https://patients.apiary.io/patients');

 if(!$json){die("Sorry connection problem! Failed to connect Practo API");}
else{
    //decode the string returned from url
   $obj = json_decode($json);
    $persons=$obj->items;
    	/*
		foreach($persons as $person){
	$out.= "<div class='patient'><input type='checkbox' value='".$person->id."'name='check_list[]'/><div class='clear'></div><h3 class='left'>".$person->name."</h3><h3 class='right'> Age:".calculateAge($person->dob)."</h3><div class='clear'></div><h3 class='left'>".$person->mobile."</h3><h3 class='left'>".$person->email."</h3><h3 class='right'> DOB:".$person->dob."</h3></div>";
	
	}*/
	
	$patients="";
	
	
    foreach($_POST['check_list'] as $check) {
	        $patient=$persons[$check];
	if((!$patient->email)){$msg[]="<h3 class='error'>patient".$patient->name." dose not have a valid mail!</h3>";}
if((!preg_match('/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/', $patient->email))){$msg[]="<h3 class='error'>patient".$patient->name." dose not have a valid mail!</h3>";}
else{ $recipients+=1;
	 $patients.= "<input type='checkbox' value='".$patient->email." 'name='check_list[]' checked/><div class='clear'></div><h3 class= left>".$patient->email."</h3><h3 class= right>".$patient->name."</h3><div class='clear'></div>"; 
	
	}
	
	}


	
	
	
	
	}
}

}




include('includes/head.php');
?>
<div class="clear"></div>
<div class="content">
<h1 id="dhead">Send Message</h1><hr/>
<div class="dbody">
<?php if(!empty($msg)){foreach($msg as $msg){echo $msg;}}?>
<form action='message.php' method='POSt'>
<h3>Message</h3>
<input type='text' name='subj' placeholder="Type your subject here" size=105>
<textarea name='body' cols=105 rows=3 placeholder="Type your message here"></textarea>
<h1>Recepients</h1><hr/>
<?php echo "<h3>".$recipients." Patients! Have valid email address</h3>";
if(!empty($patients)){echo $patients;}
else{
echo "<h3 class='warning'>you haven't selected any patients!</h3><h3><a href='patients.php'>Click here</a> to select patients</h3>";}?>
<!--<select>
  <option value="1mail">Mail Individually</option>
  <option value="Group" selected>Group Mail</option>
</select>-->
<input type="submit" name="sendMail" value="Send Mail!" <?php if($recipients==0){echo "DISABLED";}?>/>
</form></div>
</div>



<?php include('includes/foter.php');?>


</body></html><?php mysql_close($connection);?>