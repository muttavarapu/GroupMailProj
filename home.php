<?php require_once("includes/global.php");require("includes/functions.php");
if($loggedin==0){header("Location:login.php");
exit();}
if(isset($_GET['msg'])){$msg=$_GET['msg'];}
?>
<?php include('includes/head.php');
if($session_id){
$query="SELECT * FROM doctors WHERE id='$session_id' LIMIT 1";
$result = $connection->query($query) or trigger_error($mysqli->error." [$query]"); 
 if (!$result) {
    die ('There was an error running query[' . $connection->error . ']');
	
}else{while($person =$result->fetch_array()){$dName=ucfirst($person[2])." ".ucfirst($person[3]);}}
}else{redirect_to('login.php?msg="error please login again!"');}

?>
<div class="clear"></div>
<div class="content">
<h1 id='dhead'><?php echo "Greetings! Dr . ".$dName;?></h1><hr/><div class="dbody">
<p><?if(!empty($msg)){echo $msg;}?></p>
<p>View your Patients <a href='patients.php'>here!</a></p>
</hr>
</div>
</div>



<?php include('includes/foter.php');?>


</body></html><?php $connection->close();?>