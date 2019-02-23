<?php 
session_start();
session_destroy();

echo "Logouted.";

header('location:../../');
?>