<?php
    if(session_status() == PHP_SESSION_NONE) 
    { 
        session_start(); 
        include('../config/connect-db.php');
    } 

    function convertTimeToString($time){
        $timeStr = "";
        foreach(explode(":",$time) as $t){
            $timeStr.=$t;
        }
        return (int)$timeStr;
    }
    function timeRange($time,$startRange,$endRange){
        $isRange = false;
        if($time >= $startRange && $time <= $endRange){
            $isRange= true;
        }
        return $isRange;
    }
    function beforeStartTimeRange($startTime,$endTime,$startRange){
        $isBefore = false;
        if($startTime <= $startRange && $endTime >= $startRange){
            $isBefore= true;
        }
        return $isBefore;
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

        $dateArr = explode('/',date("d/m/Y"));
        $date = $dateArr[0]."/".$dateArr[1]."/".((int)$dateArr[2]+543);

        $status = 1;


        $sql = 'SELECT u.user_name as uname, MIN(TIME_FORMAT(d.bk_time, "%H:%i")) as startDate,MAX(TIME_FORMAT(d.bk_time_end,"%H:%i")) as endDate FROM hm_booking_details d INNER JOIN hm_user u ON u.user_id = d.hm_user_id WHERE d.hm_user_id = ? AND d.bk_date = ?';
            if($stmt = $mysqli->prepare($sql)){
                $stmt->bind_param('is',$uid,$date);
                if($stmt->execute()){
                    $result  = $stmt->get_result();
                    while($rs=$result->fetch_object()){
                        $cnvStartTime = convertTimeToString($startDate);
                        $cnvEndTime = convertTimeToString($endDate);

                        $startRange = convertTimeToString($rs->startDate);
                        $endRange= convertTimeToString($rs->endDate);

                        if(timeRange($cnvStartTime,$startRange,$endRange)){
                            echo "ไม่สามารถจองหมอนวด: ".$rs->uname." ในช่วงเวลา ".$rs->startDate." ถึง "."$rs->endDate"." นี้ได้";
                            $stmt -> close();
                            $mysqli -> close();
                            header('refresh:10;');
                            exit(0);
                        }else if(beforeStartTimeRange($cnvStartTime,$cnvEndTime,$startRange)){
                            echo "ไม่สามารถจองหมอนวด: ".$rs->uname." เนื่องจาก ระยะเวลาสิ้นสุด: ".$endDate." มากกว่าหรือเท่ากับ เวลาเริ่มต้นรอบถัดไป: ".$rs->startDate;
                            $stmt -> close();
                            $mysqli -> close();
                            header('refresh:10;');
                            exit(0);
                        }
                    }
                }
                $stmt -> close();
            }
        

        $sql2 = 'UPDATE hm_booking_details 
                SET bk_fullname = ?, bk_tel = ?, bk_line = ?, bk_time = ?
                , bk_time_end = ?, hm_user_id = ?, bk_id_fk = ?, bk_date = ?, status = ?
                WHERE bk_id = ?';

        if($stmt = $mysqli->prepare($sql2)){
            /* bind parameters for markers */
            $stmt->bind_param('sssssiisii',$cusname,$tel,$line,$startDate,$endDate,$uid,$bkid,$date,$status,$bid);
            
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