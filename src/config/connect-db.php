<?php
   $host = "localhost";
   $user = "root";
   $pwd = "";
   $dbname='moosi-massage';
   $port = "";
   $socket= "";
   $mysqli = new mysqli($host,$user,$pwd,$dbname,$port,$socket);
   if($mysqli->connect_error){
      die("Connection Database Fail. Check and Try again".$conDB->connect_error);
   }else{
      $mysqli->set_charset('utf8');
   }
?>