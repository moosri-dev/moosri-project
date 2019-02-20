<?php 
    include('../config/connect-db.php');
    
    $bid = $_POST['id'];
    $sql = "DELETE FROM hm_booking WHERE bk_id = ?";
   
    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param('i',$bid);
        if($stmt->execute()){

            $sql2 = "DELETE FROM hm_booking_details WHERE bk_id_fk = ?";
            if($stmt2 = $mysqli->prepare($sql2)){
                $stmt2->bind_param('i',$bid);
                if($stmt2->execute()){
                }
                $stmt2->close();
                echo true;
            }
        }
        $stmt->close();
        echo true;
    }else{
        echo false;
    }
    /* close connection */
    $mysqli->close();
    exit(0);
?>