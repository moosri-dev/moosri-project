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

        if(isset($_POST['save'])){
            include('../config/connect-db.php');
            $bname = $_POST['bname'];
            $cost = $_POST['cost'];
            $btime = $_POST['btime'];
            $detail = $_POST['detail'];

            $sql = "INSERT INTO hm_booking(bk_name,bk_detail,bk_time,bk_cost)  
                    VALUES(?,?,?,?)";

            /* create a prepared statement */
            if($stmt = $mysqli->prepare($sql)){

                /* bind parameters for markers */
                $stmt->bind_param('ssid',$bname,$detail,$btime,$cost);
                
                /* execute query */
                if($stmt->execute()){
                    echo "Insert data success!";
                    header('location: booking-management.php');
                }else{
                    echo "Error:".$sql."<br>".$mysqli->error;
                    header('refresh:2;');
                }
                /* close statement */
                $stmt->close();
                
            }else{
                echo "Error:".$sql."<br>".$mysqli->error;
                header('refresh:2;');
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
                    <h1 class="page-header">จัดการข้อมูลรายการนวด</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
            <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                        เพิ่มข้อมูลรายการนวด
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="inputPname">ชื่อรายการนวด<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="bname" class="form-control" placeholder='ชื่อรายการบริการ' maxlength='50' required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="inputPrice">ค่าบริการ<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" name="cost" class="form-control" placeholder='ค่าบริการ' maxlength='50' required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="unit">เวลาการบริการ<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" name="btime" class="form-control" placeholder='เวลา/นาที' maxlength='50' required/>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="detail">รายละเอียด :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <textarea name="detail"rows="3" class="form-control" placeholder='รายละเอียดการบริการ'></textarea>
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
</body>
</html>
