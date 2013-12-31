<?php require_once("global.php");require("includes/functions.php");
if($loggedin==0){header("Location:login.php");
exit();}?><?php 
$recipients=0;



//handling form submitted from patients.php------------->
if(isset($_POST['message'])){


//Checking credentials of selected patients------------------>
if(!empty($_POST['check_list'])) {
 //grab the patient data from api
 //$json = file_get_contents('http://localhost/Practo/patients.js');
 $json = file_get_contents('https://patients.apiary.io/patients');

 if(!$json){die("Sorry connection problem! Failed to connect Practo API");}
else{
    //decode the string returned from url
   $obj = json_decode($json);
    $persons=$obj->items;
    	
	$patients="";
	
	
    foreach($_POST['check_list'] as $check) {
	$check--;
	        $patient=$persons[$check];
	if((!$patient->email)){$msg[]="<h3 class='error'>patient ".$patient->name." dose not have a valid mail!</h3>";}
elseif((!preg_match('/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/', $patient->email))){$msg[]="<h3 class='error'>patient ".$patient->name." dose not have a valid mail!</h3>";}
else{ $recipients+=1;
	 $patients.= "<div class='selPatients'><input type='checkbox' value='".$patient->name." 'name='check_list[".$patient->email."]'  checked/><h3 class='left'>".$patient->name."</h3><h3 class= 'right'>".$patient->email."</h3></div><div class='clear'></div>"; 
	
	}
	
	}


	
	
	
	
	}
}

}




include('includes/head.php');
?>
<script>
function validateForm()
{
var x=document.forms["msg1"]["subj"].value;
var y=document.forms["msg1"]["body"].value;
if (x==null || x=="")
  {
  alert("Subject must be filled out");
  return false;
  }
  if (y==null || y=="")
  {
  alert("Message body  must be filled out");
  return false;
  }
}</script>


<div class="clear"></div>
<div class="content">
<h1 id="dhead">Send Message</h1><hr/>
<div class="dbody">
<?php if(!empty($msg)){foreach($msg as $msg){echo $msg;}}?>

<form action='viewMessage.php' method='POST' name="msg1" onsubmit="return validateForm()">
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



<?php include('includes/foter.php');
$connection->close();?>


</body></html>