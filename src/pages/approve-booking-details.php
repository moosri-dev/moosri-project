<?php
    if(session_status() == PHP_SESSION_NONE) 
    { 
        session_start(); 
        include('../config/connect-db.php');
    } 
    $status = $_POST['status'];
    $id = $_POST['id'];
    
    $sql2 = 'UPDATE hm_booking_details 
            SET  status = ?
            WHERE bk_id = ?';
  
    if($stmt = $mysqli->prepare($sql2)){
        /* bind parameters for markers */
        $stmt->bind_param('ii',$status,$id);
        
        /* execute query */
        if($stmt->execute()){
            $lc='booking-details-management.php';
            echo "Update data success!";
            header('refresh:2;url='.$lc);
        }else{
            echo "ERROR: update data failed.".$sql."<br>".$mysqli->error;
            header('refresh:2;');
        }
        /* close statement */
        $stmt->close();
        
    }else{
        echo "Error:".$sql."<br>".$mysqli->error;
        header('refresh:5;');
    }
    $mysqli->close();
    exit(0);

?>