<?php require_once("global.php");require("includes/functions.php");
if($loggedin==0){header("Location:login.php");
exit();}
if(isset($_GET['msg'])){$msg=$_GET['msg'];}
?>
<?php include('includes/head.php');
if($session_id){

$query=mysql_query("SELECT * FROM doctors WHERE id='$session_id' LIMIT 1") or die("Could not check the session");}else{redirect_to('login.php?msg="error please login again!"');}
?><?php $row=mysql_fetch_array($query);
?>
<div class="clear"></div>
<div class="content">
<h1 id='dhead'><?php echo "Greetings! Dr .".ucfirst($row[2]);?></h1><hr/><div class="dbody">
<p><?if(!empty($msg)){echo $msg;}?></p>
<p>View your Patients <a href='patients.php'>here!</a></p>
</hr>
</div>
</div>



<?php include('includes/foter.php');?>


</body></html><?php mysql_close($connection);?>