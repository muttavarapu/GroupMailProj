<?php require("connection.php");


 

$email=$_GET["q"];
$email=strtolower($email);

if(!preg_match('/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/', $email)){ //validate email address - check if is a valid email address
			$response= "You have entered an invalid email address!";}
else{

$query="SELECT * FROM doctors WHERE email='$email' LIMIT 1";
					
$result = $connection->query($query) or trigger_error($mysqli->error." [$query]"); 
			$check=mysqli_num_rows($result);
if($check==0){ //if user has not already registered we just return available
  
  $response="Available";
}elseif($check !=0){
 
$response="Email address already registered with us";
}else{$response="Users data read failed"; }
}

echo $response;

?>