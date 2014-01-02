<?php require("connection.php");





 

$uname=$_GET["q"];
$uname=strtolower($uname);
if(strlen($uname)>4){
$query="SELECT * FROM doctors WHERE username='$uname' LIMIT 1";
					
$result = $connection->query($query) or trigger_error($mysqli->error." [$query]"); 
			$check=mysqli_num_rows($result);
if($check==0){ //if user hasn't already registered we just return the current number of votes
  
  $response="Available";
}elseif($check !=0){
 
$response="Not available";
}else{$response="Users data read failed"; }
}else{$response="Username should be atleast 5 chars long";}

echo $response;


?>