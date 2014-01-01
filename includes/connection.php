<?php 
dl("mysqli.so");
$connection = new mysqli("b13013ns7636sg5v.mysql.clvrcld.net","uhruoelhd77j0pf7","2c6c28c236794a56ae72ecf4e1128ba1","b13013ns7636sg5v");
ini_set("error_reporting","E_ALL");
if ($connection->connect_errno > 0) {
    die ('Unable to connect to database [' . $connection->connect_error . ']');
}else{echo "connected";}?>