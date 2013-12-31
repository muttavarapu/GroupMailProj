<?php require_once("includes/global.php");
require("includes/functions.php");$message="";if(isset($_GET['msg'])){$message=$_GET['msg'];}
if($loggedin==0){redirect_to("login.php?msg='You need to login to continue'");
exit();}?><?php 
if($session_id){
$query="SELECT * FROM doctors WHERE id='$session_id' LIMIT 1";
$result = $connection->query($query) or trigger_error($mysqli->error." [$query]"); 
 if (!$result) {
    die ('There was an error running query[' . $connection->error . ']');
}
}
else{redirect_to('login.php?msg="error please login again!"');}
include('includes/head.php');
?>
<div class="clear"></div>
<div class="content">
<?php $row=$result->fetch_array();
echo "<h1 class='left'>Greetings! Dr .".ucfirst($row[2])." </h1>";?>
<h1 class='right'><a href="edit_profile.php">Edit Profile</a></h1 id='dhead'><div class="clear"></div><hr/><div class="dbody">
<p><?php 
if(!empty($message)){echo $message;}
echo "Last Logged in:       ".$row['lastlogged'];   echo "<br/>Active Since:       ".$row['signupdate'];   
echo "</br>About me  :   ".nl2br($row['about']); ?></p>
</hr>
</div>
</div>




<?php include('includes/foter.php');
$connection->close();?>

</body></html>