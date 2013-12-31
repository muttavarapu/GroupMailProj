<?php require_once("includes/global.php");
require("includes/functions.php");

if($loggedin ==1){redirect_to('home.php');}
include('includes/head.php');
$query="SELECT id, firstname, lastname, LEFT(about, 160) as aboutme  FROM doctors ";

$out="";
$result = $connection->query($query) or trigger_error($mysqli->error." [$query]"); 
 if (!$result) {
    die ('There was an error running query[' . $connection->error . ']');
}

        
	while($person =$result->fetch_array()){
	
	$readmore=$person['aboutme'];
$lastspace=strrpos($readmore," ");
$read=substr($readmore,0,$lastspace);
	$out.= "<div class='doctor'><a href='viewdoctor.php?id=".$person['id']."'/><div class='clear'></div><h3 class='left'> Dr. ".$person['firstname'].$person['lastname']."</h3><div class='clear'></div><p class='left'>".$read."....<span class='read'>Readmore</span></p></a></div>";
	
	}

?>

<div class="clear"></div>
<div class="content">
<h1 id="dhead">Doctors available at Practo </h1><hr/><div class="dbody">
<?php  if(!empty($message)){ echo $message;}?>
<p><?php echo $out;?></p>
</hr>

</div></div>




<?php include('includes/foter.php');
$connection->close();?>
</body></html>