<?php
   $host = "localhost";
   $user = "root";
   $pwd = "";
   $dbname='moosi-massage';
   $mysqli = new mysqli($host,$user,$pwd,$dbname);
   if($mysqli->connect_error){
      die("Connection Database Fail. Check and Try again".$conDB->connect_error);
   }else{
      $mysqli->set_charset('utf8');
   }
?>