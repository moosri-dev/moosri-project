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

        function editBooking(id){
            let url = "pages/edit-booking-details.php?id="+id;
            window.location.href = url;
        }

        function viewBookingDetails(id,ddate){
            let url = "pages/massager-schedule.php?id="+id+"&ddate="+ddate;
            window.location.href = url;
        }
        function print(id,ddate){
            let url = "pages/booking-report.php?id="+id+"&ddate="+ddate;
            window.location.href = url;
        }

    </script>

    
</head>

<body>
    <div id="wrapper">
        <?php include('../components/menu.php'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">จัดการข้อมูลรายการบริการ</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            ตารางข้อมูลรายการบริการ
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="myTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">ชื่อหมอนวด</th>
                                            <th class="text-center">เวลาเริ่มต้น</th>
                                            <th class="text-center">เวลาสิ้นสุด</th>
                                            <th class="text-center">วันที่</th>
                                            <th class="text-center">รายได้รวม</th>
                                            <th class="text-center">พิมพ์</th>
                                            <th class="text-center">แก้ไข</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        include('../config/connect-db.php');
                                        $sql= 'SELECT d.bk_id as bid, d.bk_fullname as fullname, d.bk_tel as tel
                                        , d.bk_line as bline, MIN(TIME_FORMAT(d.bk_time, "%H:%i")) as startDate, MAX(TIME_FORMAT(d.bk_time_end,"%H:%i")) as endDate, d.bk_date as ddate,d.status as st
                                        , u.user_id as uid, u.user_name as username, b.bk_name as bname,SUM(b.bk_cost) as cost
                                                FROM hm_booking_details d INNER JOIN hm_booking b ON d.bk_id_fk = b.bk_id
                                                INNER JOIN hm_user u ON d.hm_user_id = u.user_id  WHERE d.status <> ? GROUP BY d.bk_date';
                                        
                                        if($stmt = $mysqli->prepare($sql)){
                                            $status = 0;
                                            $stmt->bind_param('i',$status);
                                            $stmt->execute();
                                            $result  = $stmt->get_result();
                                            while($rs=$result->fetch_object()){
                                                    echo '<tr>';
                                                    echo '<td class="text-center"><i class="fa fa-eye icon" onclick="viewBookingDetails('.$rs->uid.',\''.$rs->ddate.'\')"></i></td>';
                                                    echo '<td class="text-center">'.$rs->username.'</td>';
                                                    echo '<td class="text-center">'.$rs->startDate.'</td>';
                                                    echo '<td class="text-center">'.$rs->endDate.'</td>';
                                                    echo '<td class="text-center">'.$rs->ddate.'</td>';
                                                    echo '<td class="text-center">'.$rs->cost.'</td>';
                                                    echo '<td class="text-center"><i class="fa fa-file-pdf-o icon" aria-hidden="true" onclick="print('.$rs->uid.',\''.$rs->ddate.'\');"></i></td>';
                                                    echo '<td class="text-center"><i class="fa fa-pencil-square-o icon" aria-hidden="true" onclick="editBooking('.$rs->bid.')"></i></td>';
                                                    echo '</tr>';
                                            }
                                            $stmt->close();
                                        }
                                        $mysqli->close();
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
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
    <script type="text/javascript">
        function openSchedule(id){
            let url = "pages/massager-schedule.php?id="+id;
            window.location.href = url;
        }
    </script>

</html>
