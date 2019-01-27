<?php
 
 $host = "localhost";
 $user = "root";
 $pwd = "";
 $conDB = new mysqli($host,$user,$pwd);

 if($conDB->connect_error){
    die("Connection Database Fail. Check and Try again".$conDB->connect_error);
 }else{
    echo "Connected Database Successfully., end join";
 }
?>