<?php require_once("global.php");require("includes/functions.php");
if($loggedin==0){$msg="Login to continue!";
$goto ='login.php?msg='.$msg;
redirect_to($goto);} 
if(isset($_GET['msg'])){$msg[]=$_GET['msg'];}
if($session_id){

$query="SELECT id,subject, LEFT(message, 145) AS body,sent_on,recipients FROM messages WHERE d_id='$session_id'";
$result = $connection->query($query) or trigger_error($mysqli->error." [$query]");
if (!$result) {
    die ('There was an error running query[' . $connection->error . ']');
}
 
}
else{redirect_to('login.php?msg="error please login again!"');}

if(mysqli_num_rows($result)>0){$output="";
while($row=$result->fetch_array()){
$readmore=$row['body'];
$lastspace=strrpos($readmore," ");
$read=substr($readmore,0,$lastspace);
$output.= "<div class='msg'><h2 class='subj'>Subj: ".$row['subject']."</h2><h2 class='date'>Sent On : ".$row['sent_on']."</h2><div class='clear'></div><p>".$read."...<a href='viewMessage.php?id=".$row['id']."'>View Message</a></p><h3>Recipients: ".$row['recipients']."</h3></div>";
}}
else{$output= "<p class='msg'>You haven't sent any messages</p>";
}

include('includes/head.php');



?>
<div class="clear"></div>
<div class="content">
<h1 id="dhead">Sent Messages</h1><hr/>
<div class="dbody">
<?php if(!empty($msg)){foreach($msg as $msg){echo "<p class='msg'>".$msg."</p>";}}
echo $output;

?>
</div>
</div>



<?php include('includes/foter.php');
$connection->close();?>


</body></html>