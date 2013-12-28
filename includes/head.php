<!DOCTYPE html>
<html lang="en-US"><head><title>Welcome to Tutoscoop|The free tutorial place</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="head"><h1><a href="index.php">Practo</a></h1>
<p>When appointments go Online!</p>
<?php if($loggedin==0){echo '<ul id="top"><li class="left"><a href="index.php">Practoo!</a></li><li class="right"><a href="register.php">Register</a></li><li class="right"><a href="login.php">Login</a></li></ul>';}
else {
echo '<ul id="top"><li class="left"><a href="home.php">Home</a></li><li class="left"><a href="patients.php">Patients</a></li><li class="left"><a href="messages.php">SentMessages</a></li><li class="right"><a href="logout.php">Logout</a></li><li class="right"><a href="profile.php">Profile</a></li></ul>';} ?>
</div><div class='clear'></div>