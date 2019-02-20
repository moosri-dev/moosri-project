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
        $sql= 'SELECT bk_id as bid, bk_name as bname, bk_detail as details, bk_time as btime, bk_cost as cost
                FROM hm_booking WHERE bk_id = ?
        ';
        if($stmt = $mysqli->prepare($sql)){
            $bid = $_GET['id'];
            $stmt->bind_param('i',$bid);
           
            if($stmt->execute()){
                $result  = $stmt->get_result();
                while($rs=$result->fetch_object()){
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
                            <form method="post" action="pages/update-booking.php">
                                <div class="form-group row">
                                <input type="text" name="bid" value="<?php echo $rs->bid; ?>" hidden required/>
                                    <div class="col-md-4 text-right">
                                        <label for="inputPname">ชื่อรายการนวด<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="bname" class="form-control" placeholder='ชื่อรายการบริการ' maxlength='50' value="<?php echo $rs->bname; ?>" required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="inputPrice">ค่าบริการ<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" name="cost" class="form-control" placeholder='ค่าบริการ' maxlength='50' value="<?php echo $rs->cost; ?>" required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="unit">เวลาการบริการ<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" name="btime" class="form-control" placeholder='เวลา/นาที' maxlength='50' value="<?php echo $rs->btime; ?>" required/>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="detail">รายละเอียด :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <textarea name="detail"rows="3" class="form-control" placeholder='รายละเอียดการบริการ'><?php echo $rs->details; ?>"</textarea>
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
    <?php
            }
        }
            $stmt->close();
    }
    $mysqli->close();
    ?>
</body>
</html>
