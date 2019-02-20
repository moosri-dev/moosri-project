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



        if(isset($_POST['save'])){
            $bkid = $_POST['bkid'];
            $uid = $_POST['uid'];
            $cusname = $_POST['cusname'];
            $tel = $_POST['tel'];
            $line = $_POST['line'];
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
    
            $sql2 = 'INSERT INTO hm_booking_details(bk_fullname,bk_tel,bk_line,bk_time,bk_time_end,hm_user_id,bk_id_fk) 
                    VALUES(?,?,?,?,?,?,?)';
    
            include('../config/connect-db.php');
            if($stmt = $mysqli->prepare($sql2)){
                /* bind parameters for markers */
                $stmt->bind_param('sssssii',$cusname,$tel,$line,$startDate,$endDate,$uid,$bkid);
                
                /* execute query */
                if($stmt->execute()){
                    $lc='booking-details-management.php';
                    echo "Insert data success!";
                    header('refresh:2;url='.$lc);
                }else{
                    echo "ERROR: Insert data failed.".$sql."<br>".$mysqli->error;
                    header('refresh:2;');
                }
                /* close statement */
                $stmt->close();
                
            }else{
                echo "Error:".$sql2."<br>".$mysqli->error;
                header('refresh:5;');
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
                        แก้ไขข้อมูลการจอง
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