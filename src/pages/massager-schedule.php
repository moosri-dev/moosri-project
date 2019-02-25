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

  <?php 
    include('../components/global-variable.php');
    include('../assets/scripts/admin-script.php');
    echo '<title>'.$title.'</title>';
  ?>

<!-- DataTables JavaScript -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
     <script type="text/javascript">
        $(document).ready(function() {
            $('#myTable').DataTable({
                responsive: true
            });
        });
    </script>
</head>

<body>
    <div id="wrapper">
        <?php include('../components/menu.php'); ?>
        <div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <?php
                            include('../config/connect-db.php');
                            $sql= 'SELECT user_name as uname FROM hm_user WHERE user_id = ?';

                            if($stmt = $mysqli->prepare($sql)){
                                $stmt->bind_param('i',$_GET['id']);
                                $stmt->execute();
                                $result  = $stmt->get_result();
                                while($rs=$result->fetch_object()){
                                    echo '<p><b>ชื่อหมอนวด: <span style="color:blue;">'.$rs->uname.'</span></b></p>';
                                    echo '<p>วันที่: '.$_GET['ddate'].'</p>';
                                }
                                $stmt->close();
                            }
                            $mysqli->close();
                        ?>
                     </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
            <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            ตารางข้อมูลเวลาการทำงาน
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width:5%">#</th>
                                        <th class="text-center" style="width:10%">เวลาเริ่มต้น</th>
                                        <th class="text-center" style="width:10%">เวลาสิ้นสุด</th>
                                        <th class="text-center" style="width:15%">รายการบริการ</th>
                                        <th class="text-center" style="width:10%">เวลา/นาที.</th>
                                        <th class="text-center" style="width:15%">ราคา</th>
                                        <th class="text-center" style="width:15%">ชื่อลูกค้า</th>
                                        <th class="text-center" style="width:10%">เบอร์โทร</th>
                                        <th class="text-center" style="width:10%">ไลน์</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    include('../config/connect-db.php');
                                    $sql= 'SELECT d.bk_id as id, d.bk_fullname as dname, d.bk_tel as tel, d.bk_line as dline, d.bk_time as startDate
                                    , d.bk_time_end as endDate,d.bk_date as ddate,d.status as st
                                    , d.hm_user_id as uid, b.bk_name as bname, b.bk_detail as detail
                                    , b.bk_time as btime, b.bk_cost as cost
                                        FROM hm_booking_details d INNER JOIN hm_booking b ON d.bk_id_fk = b.bk_id
                                        WHERE hm_user_id = ? AND d.bk_date =? AND d.status <> ?';
                        
                                    if($stmt = $mysqli->prepare($sql)){
                                        $status = 0;
                                        $stmt->bind_param('isi',$_GET['id'],$_GET['ddate'],$status);
                                        $stmt->execute();
                                        $result  = $stmt->get_result();
                                        $row = 1;
                                        while($rs=$result->fetch_object()){
                                            echo '<tr>';
                                            echo '<td class="text-center">'.$row.'</td>';
                                            echo '<td class="text-center">'.$rs->startDate.'</td>';
                                            echo '<td class="text-center">'.$rs->endDate.'</td>';
                                            echo '<td class="text-center">'.$rs->bname.'</td>';
                                            echo '<td class="text-center">'.$rs->btime.'</td>';
                                            echo '<td class="text-center">'.$rs->cost.'</td>';
                                            echo '<td class="text-center">'.$rs->dname.'</td>';
                                            echo '<td class="text-center">'.$rs->tel.'</td>';
                                            echo '<td class="text-center">'.$rs->dline.'</td>';
                                            echo '</tr>';
                                            $row++;
                                        }
                                        $stmt->close();
                                    }
                                    $mysqli->close();
                                  ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    <a class="btn btn-lg btn-primary" href="pages/user-booking-management.php"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbspย้อนกลับ</a>
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
