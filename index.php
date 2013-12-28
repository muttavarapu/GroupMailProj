<?php require_once("global.php");
require("includes/functions.php");

if($loggedin ==1){redirect_to('home.php');}
include('includes/head.php');
$query=mysql_query("SELECT id, firstname, lastname, LEFT(about, 145) as aboutme  FROM doctors") or die("Failed to connect to database".mysql_error());
$out="";
	while($person =mysql_fetch_array($query)){
	$out.= "<div class='doctor'><a href='viewdoctor.php?id=".$person['id']."'/><div class='patient'><div class='clear'></div><h3 class='left'> Dr. ".$person['firstname'].$person['lastname']."</h3><div class='clear'></div><h3 class='left'>".$person['aboutme']."</h3></div></a></div>";
	
	}

?>

<div class="clear"></div>
<div class="content">
<h1 id="dhead">Doctors available at Practo </h1><hr/><div class="dbody">
<?php  if(!empty($message)){ echo $message;}?>
<p><?php echo $out;?></p>
</hr>

</div></div>





</body></html>