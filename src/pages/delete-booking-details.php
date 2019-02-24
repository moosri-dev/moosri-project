<?php 
    include('../config/connect-db.php');
    
    $bid = $_REQUEST['id'];
    $sql = "UPDATE hm_booking_details tbk SET tbk.status = '0' WHERE bk_id = ?";
   
    /* create a prepared statement */
    if($stmt = $mysqli->prepare($sql)){

         /* bind parameters for markers */
        $stmt->bind_param('i',$bid);
        
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