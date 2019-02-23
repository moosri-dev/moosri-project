<?php
    if(session_status() == PHP_SESSION_NONE) 
    { 
        session_start(); 
    } 
    if(isset($_POST['update'])){
        
        $bid = $_POST['bid'];
        $bkid = $_POST['bkid'];
        $uid = $_POST['uid'];
        $cusname = $_POST['cusname'];
        $tel = $_POST['tel'];
        $line = $_POST['line'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];

        $sql = 'UPDATE hm_booking_details 
                SET bk_fullname = ?, bk_tel = ?, bk_line = ?, bk_time = ?
                , bk_time_end = ?, hm_user_id = ?, bk_id_fk = ?
                WHERE bk_id = ?';

        include('../config/connect-db.php');
        if($stmt = $mysqli->prepare($sql)){
            /* bind parameters for markers */
            $stmt->bind_param('sssssiii',$cusname,$tel,$line,$startDate,$endDate,$uid,$bkid,$bid);
            
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
    }

?>