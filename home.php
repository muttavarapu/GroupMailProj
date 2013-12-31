<?php require_once("global.php");require("includes/functions.php");
if($loggedin==0){header("Location:login.php");
exit();}
if(isset($_GET['msg'])){$msg=$_GET['msg'];}
?>
<?php include('includes/head.php');
if($session_id){

}else{redirect_to('login.php?msg="error please login again!"');}
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


</body></html><?php $connection->close();?>