<?php require_once("global.php");
require("includes/functions.php");
if(isset($_GET['id'])){$id=$_GET['id'];}
else{
$goto ='index.php?msg=click on a doctor to view';
redirect_to($goto);
}
if($loggedin ==1){redirect_to('home.php');}
include('includes/head.php');
$query="SELECT id, firstname, lastname, about FROM doctors where id='$id' LIMIT 1";

$result = $connection->query($query) or trigger_error($mysqli->error." [$query]");
if (!$result) {
    die ('There was an error running query[' . $connection->error . ']');
}
$out="";


	while($person =$result->fetch_array()){
		$out.= "<div class='doctor1'><div class='clear'></div><h3 class='left'> Dr. ".$person['firstname'].$person['lastname']."</h3><div class='clear'></div><p class='left'>".$person['about']."</p></div>";
	
	}

?>

<div class="clear"></div>
<div class="content">
<h1 id="dhead">Doctors Profile </h1><hr/><div class="dbody">
<?php  if(!empty($message)){ echo $message;}?>
<p><?php echo $out;?></p>
</hr>

</div></div>





</body>
<?php include('includes/foter.php');
$connection->close();?></html>