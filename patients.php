<?php $out ="errorcheck";
include('includes/head.php');
?>
<div class="clear"></div>
<div class="content">
<h1 id="dhead"><?php echo " Dr .ucfirst($row[2]) These are your patients";?></h1><hr/><div class="dbody">
<? if(!empty($message)){ echo $message;}?>
<?php echo $out;?>
</hr>

</div></div>






</body></html>