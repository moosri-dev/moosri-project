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
           $uid = $_POST['uid'];
           $status = 1;

           $spDate = explode('/',date('d/m/Y'));
           $day = $spDate[0];
           $month = $spDate[1];
           $year = (int)$spDate[2]+543;
            $ctime = date('H:i:s');
            $startDate = $day."/".$month."/".$year+":"+$ctime;

            $sql = "INSERT INTO hm_works(user_id,start_date,status) VALUES(?,?,?)";
            if($stmt = $mysqli->prepare($sql)){
                $stmt->bind_param("isi",$uid,$startDate,$status);
                if($stmt->execute()){
                    echo "Insert data success!";
                    header('location: admin-management.php');
                }else{
                    echo "Error:".$sql."<br>".$mysqli->error;
                    header('refresh:2;');
                }
                $stmt -> close();
            }
        }
    ?>
</head>

<body>
    <div id="wrapper">
        <?php include('../components/menu.php'); ?>
        <div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">จัดการข้อมูลเวลาทำงาน</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
            <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            เวลาทำงาน
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="myTable">
                                    <thead>
                                        <tr>
                                            <th style="width:5%;">#</th>
                                            <th style="width:25%;">รูปโปรไฟล์</th>
                                            <th style="width:25%;">ชื่อผู้ใช้งาน</th>
                                            <th style="width:25%;">ชื่อ-นามสกุล</th>
                                            <th style="width:10%;">แก้ไข</th>
                                            <th style="width:10%;">ลบ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        include('../config/connect-db.php');
                                        $status_id = 2;
                                        $sql= 'SELECT 
                                                    u.user_id as id, u.user_user as username,u.user_name as name
                                                    ,u.user_img as image
                                                FROM hm_user u
                                                WHERE u.status_id =?';

                                        if($stmt = $mysqli->prepare($sql)){
                                            $stmt->bind_param('i',$status_id);
                                            $stmt->execute();
                                            $result  = $stmt->get_result();
                                            $rows = 1;
                                            while($rs=$result->fetch_object()){
                                                echo '<tr>';
                                                echo '<td class="text-center">'.$rows.'</td>';
                                                echo '<td class="text-center"><img src="'.'uploads/'.$rs->image.'" class="item image"/></td>';
                                                echo '<td class="text-center">'.$rs->username.'</td>';
                                                echo '<td class="text-center">'.$rs->name.'</td>';
                                                echo '<td class="text-center"><i class="fa fa-pencil-square-o icon" aria-hidden="true" onclick="editUser('.$rs->id.')"></i></td>';
                                                echo '<td class="text-center"><i class="fa fa-ban icon" aria-hidden="true" onclick="deleteUser('.$rs->id.','."'$rs->username'".')"></i></td>';
                                                echo '</tr>';
                                                $rows++;
                                            }
                                            $stmt->close();
                                        }
                                        $mysqli->close();
                                    ?>
                                    </tbody>
                                </table>
                                <!-- /.table-responsive -->
                            </div>
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
<?php $mysqli->close(); ?>
</html>
