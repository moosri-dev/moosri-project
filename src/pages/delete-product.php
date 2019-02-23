<?php 
    include('../config/connect-db.php');
    
    $pid = $_POST['pid'];
    $sql = "DELETE FROM hm_product WHERE product_id = ?";
   
    /* create a prepared statement */
    if($stmt = $mysqli->prepare($sql)){

         /* bind parameters for markers */
        $stmt->bind_param('i',$pid);
        
        /* execute query */
        $stmt->execute();

        /* close statement */
        $stmt->close();

        echo true;
    }else{
        echo false;

    }
    /* close connection */
    $mysqli->close();
    exit(0);
?>