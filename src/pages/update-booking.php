<?php
    if(session_status() == PHP_SESSION_NONE) 
    { 
        session_start(); 
    } 
    if(isset($_POST['update'])){
        
        $bid = $_POST['bid'];
        $bname = $_POST['bname'];
        $cost = $_POST['cost'];
        $btime = $_POST['btime'];
        $details = $_POST['detail'];
        $sql = 'UPDATE hm_booking 
                SET bk_name = ?, bk_detail = ?, bk_time = ?, bk_cost = ? 
                WHERE bk_id = ?';

        include('../config/connect-db.php');
        /* create a prepared statement */
        if($stmt = $mysqli->prepare($sql)){
            /* bind parameters for markers */
            $stmt->bind_param('ssidi',$bname,$details,$btime,$cost,$bid);
            
            /* execute query */
            if($stmt->execute()){
                $lc='booking-management.php';
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