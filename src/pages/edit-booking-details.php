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
        $sql= 'SELECT d.bk_id as bid, d.bk_fullname as cusname, d.bk_tel as tel
        , d.bk_line as bline, d.bk_time as startDate, d.bk_time_end as endDate
        ,u.user_id as uid, u.user_name as uname, b.bk_id as bkid, b.bk_name as bname 
                FROM hm_booking_details d INNER JOIN hm_booking b ON d.bk_id_fk = b.bk_id
                INNER JOIN hm_user u ON d.hm_user_id = u.user_id WHERE d.bk_id =?';
        
        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param('i',$_GET['id']);
            if($stmt->execute()){
                $result  = $stmt->get_result();
                while($rs=$result->fetch_object()){
                    $bid = $rs->bid;
                    $bkid = $rs->bkid;
                    $bname = $rs->bname;

                    $uid = $rs->uid;
                    $uname = $rs->uname;
                    $cusname = $rs->cusname;
                    $tel = $rs->tel;
                    $line = $rs->bline;
                    $startDate = $rs->startDate;
                    $endDate = $rs->endDate;
                }
            }
            $stmt->close();
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
                        แก้ไขข้อมูลการจอง
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form method="post" action="pages/update-booking-details.php">
                                <div class="form-group row">
                                <input type="text" name="bid" value="<?php echo $bid; ?>" hidden required/>
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
                                                            if($bkid == $rs->bid){
                                                                echo '<option value="'.$rs->bid.'" selected> '.$rs->bname.'</option>';
                                                            }else{
                                                                echo '<option value="'.$rs->bid.'"> '.$rs->bname.'</option>';
                                                            }
                                                            
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
                                                $status = 2;
                                                $sql= 'SELECT user_id as uid, user_name as uname FROM hm_user WHERE status_id=?';
                                                $stmt->bind_param("i",$status);
                                                
                                                if($stmt = $mysqli->prepare($sql)){
                                                    $status = 2;
                                                    $stmt->bind_param("i",$status);
                                                    if($stmt->execute()){
                                                        $result  = $stmt->get_result();
                                                        while($rs=$result->fetch_object()){
                                                            if($uid == $rs->uid){
                                                                echo '<option value="'.$rs->uid.'" selected> '.$rs->uname.'</option>';
                                                            }else{
                                                                echo '<option value="'.$rs->uid.'"> '.$rs->uname.'</option>';
                                                            }
                                                            
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
                                        <input type="text" name="cusname" class="form-control" maxlength="50" value = "<?php echo $cusname; ?>" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="inputPhone">เบอร์โทร<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="tel" name="tel" class="form-control" maxlength="10" value = "<?php echo $tel; ?>" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="inputLine">ไลน์<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="line" class="form-control" maxlength="50" value = "<?php echo $line; ?>" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="startDate">เวลาเริ่มต้น<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="time" name="startDate" class="form-control" id="startDate" name="endDate" min="09:00" max="21:00" value = "<?php echo $startDate; ?>" onchange="myStartDateKeyChange(event,this);" onkeyup="myStartDateKeyChange(event,this);" required >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="endDate">เวลาสิ้นสุด<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="time" name="endDate" class="form-control" id="endDate" name="endDate" min="<?php echo $startDate; ?>" max="22:00" value = "<?php echo $endDate; ?>" required >
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-lg btn-block btn-primary" name="update">บันทึกข้อมูล</button>
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
    <?php $mysqli->close(); ?>
</body>
</html>
