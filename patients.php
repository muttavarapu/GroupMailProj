<?php require_once("global.php");require("includes/functions.php");
if($loggedin==0){header("Location:login.php");
exit();}?><?php 




 //grab the patient data from api
 //$json = file_get_contents('http://localhost/Practo/patients.js');
 $json = file_get_contents('https://patients.apiary.io/patients');
//the returned json data is in string format


if(!$json){die("Sorry connection problem! Failed to connect Practo API");}
else{
//decode the string
   $obj = json_decode($json);
    $persons=$obj->items;
    
	$out="<form action='message.php' method='POST'><input type='submit' name='message' value='Send message' id='msgSubmit'/><div class='clear'></div>";
    	
		foreach($persons as $person){
	$out.= "<div class='patient'><input type='checkbox' value='".$person->id."'name='check_list[".$person->id."]'/><h3 class='left'>".$person->name."</h3><h3 class='right'> Age:".calculateAge($person->dob)."</h3><div class='clear'></div><h3 class='left'>".$person->mobile."</h3><h3 class='right'> DOB: ".$person->dob."</h3><h3 class='left'>Email : ".$person->email."</h3></div>";
	
	}
	
	$out.="<input type='submit' name='message' value='Send message' id='msgSubmit'/></form>";
	
	}




if($session_id){

$query="SELECT * FROM doctors WHERE id='$session_id' LIMIT 1";
$result = $connection->query($query) or trigger_error($mysqli->error." [$query]");
if (!$result) {
    die ('There was an error running query[' . $connection->error . ']');
}
}
else{redirect_to('login.php?msg="error please login again!"');}
include('includes/head.php');
?><?php $row=$result->fetch_array();
?>
<div class="clear"></div>
<div class="content">
<h1 id="dhead"><?php echo " Dr .".ucfirst($row[2])." These are your patients";?></h1><hr/><div class="dbody">
<? if(!empty($message)){ echo $message;}?>
<?php echo $out;?>
</hr>

</div></div>



<?php include('includes/foter.php');
$connection->close();?>


</body></html>