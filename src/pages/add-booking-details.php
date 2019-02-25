<?php
    if(session_status() == PHP_SESSION_NONE) 
    { 
        session_start(); 
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="../assets/css/style.css">
   
    <?php 
        include('../components/global-variable.php');
        include('../assets/scripts/admin-script.php');
        echo '<title>'.$title.'</title>';
       
        include('../config/connect-db.php');


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

        if(isset($_POST['save'])){
            $bkid = $_POST['bkid'];
            $uid = $_POST['uid'];
            $cusname = $_POST['cusname'];
            $tel = $_POST['tel'];
            $line = $_POST['line'];
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
            $createDate =$_POST['createDate'];
            $dateArr = explode('-',$createDate);
            $date = $dateArr[2]."/".$dateArr[1]."/".((int)$dateArr[0]+543);

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
            $sql2 = 'INSERT INTO hm_booking_details(bk_fullname,bk_tel,bk_line,bk_time,bk_time_end,hm_user_id,bk_id_fk,bk_date,status) 
                    VALUES(?,?,?,?,?,?,?,?,?)';
    
            include('../config/connect-db.php');
            if($stmt = $mysqli->prepare($sql2)){
                /* bind parameters for markers */
                $stmt->bind_param('sssssiisi',$cusname,$tel,$line,$startDate,$endDate,$uid,$bkid,$date,$status);
                
                /* execute query */
                if($stmt->execute()){
                    $lc='booking-details-management.php';
                    echo "Insert data success!";
                    header('refresh:3;url='.$lc);
                }else{
                    echo "ERROR: Insert data failed.".$sql2."<br>".$mysqli->error;
                    header('refresh:2;');
                }
                /* close statement */
                $stmt->close();
                
            }else{
                echo "Error:".$sql2."<br>".$mysqli->error;
                header('refresh:3;');
            }
            $mysqli->close();
            exit(0);
        }
    ?>
</head>

<body>
    <div id="wrapper">
        <?php include('../components/menu.php'); ?>
        <div id="page-wrapper">
        
        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">ข้อมูลจองรายการนวด</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
            <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                        เพิ่มข้อมูลการจอง
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form method="post">
                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="inputBooking">ชื่อรายการนวด<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                       <select name="bkid" class="form-control" required>
                                            <?php 
                                                $sql= 'SELECT bk_id as bid, bk_name as bname FROM hm_booking';
                                                
                                                if($stmt = $mysqli->prepare($sql)){
                                                    if($stmt->execute()){
                                                        $result  = $stmt->get_result();
                                                        while($rs=$result->fetch_object()){
                                                                echo '<option value="'.$rs->bid.'"> '.$rs->bname.'</option>';
                                                        }
                                                    }
                                                    $stmt->close();
                                                }
                                            ?>
                                       </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="inputUser">ชื่อหมอนวด<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                       <select name="uid" class="form-control" required>
                                            <?php 
                                                $sql= 'SELECT user_id as uid, user_name as uname FROM hm_user WHERE status_id =?';
                                                
                                                if($stmt = $mysqli->prepare($sql)){
                                                    $status = 2;
                                                    $stmt->bind_param("i",$status);
                                                    if($stmt->execute()){
                                                        $result  = $stmt->get_result();
                                                        while($rs=$result->fetch_object()){
                                                                echo '<option value="'.$rs->uid.'"> '.$rs->uname.'</option>';
                                                        }
                                                    }
                                                    $stmt->close();
                                                }
                                            ?>
                                       </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="inputCusname">ชื่อลูกค้า<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="cusname" class="form-control" maxlength="50"required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="inputPhone">เบอร์โทร<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="tel" name="tel" class="form-control" maxlength="10" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="inputLine">ไลน์<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="line" class="form-control" maxlength="50" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="inputCreateDate">วันที่<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="date" name="createDate" class="form-control" min="2019-01-01" max="2030-12-31" onkeydown="return false" required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="startDate">เวลาเริ่มต้น<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="time" name="startDate" class="form-control" id="startDate" name="endDate" min="09:00" max="21:00" onchange="myStartDateKeyChange(event,this);" onkeyup="myStartDateKeyChange(event,this);" required >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="endDate">เวลาสิ้นสุด<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="time" name="endDate" class="form-control" id="endDate" name="endDate" min="09:00" max="22:00" required >
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-lg btn-block btn-primary" name="save">บันทึกข้อมูล</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <script type="text/javascript">
        function myStartDateKeyChange(event,param){
            document.getElementById('endDate').value = "";
            document.getElementById('endDate').min = param.value;
        }
    </script>
</body>
</html>
