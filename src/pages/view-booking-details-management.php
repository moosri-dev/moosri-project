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

        function approveBooking(bid,bst){
                $.post('pages/approve-booking-details.php',{id:bid,status:bst},function(response){
               if(response){
                alert("Approve Booking Success.");
                location.reload();
               }else{
                   alert('Approve Booking Failed.');
                }
             });
        }
        function cancelBooking(bid,bst){
                $.post('pages/approve-booking-details.php',{id:bid,status:bst},function(response){
               if(response){
                alert("Cancel Booking Success.");
                location.reload();
               }else{
                   alert('Cancel Booking Failed.');
                }
             });
        }
        function editBooking(id){
            let url = "pages/edit-booking-details.php?id="+id;
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
                                            <th class="text-center">รายการบริการ</th>
                                            <th class="text-center">ชื่อหมอนวด</th>
                                            <th class="text-center">ชื่อลูกค้า</th>
                                            <th class="text-center">เวลาเริ่มต้น</th>
                                            <th class="text-center">เวลาสิ้นสุด</th>
                                            <th class="text-center">วันที่</th>
                                            <th class="text-center">เบอร์โทร</th>
                                            <th class="text-center">ไลน์</th>
                                            <th class="text-center">สถานะการจอง</th>
                                            <th class="text-center">แก้ไข</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        include('../config/connect-db.php');
                                        $sql= 'SELECT d.bk_id as bid, d.bk_fullname as fullname, d.bk_tel as tel
                                        , d.bk_line as bline, d.bk_time as startDate, d.bk_time_end as endDate,d.bk_date as ddate,d.status as st
                                        , u.user_id as uid, u.user_name as username, b.bk_name as bname
                                                FROM hm_booking_details d INNER JOIN hm_booking b ON d.bk_id_fk = b.bk_id
                                                INNER JOIN hm_user u ON d.hm_user_id = u.user_id';
                                        
                                        if($stmt = $mysqli->prepare($sql)){
                                            $stmt->execute();
                                            $result  = $stmt->get_result();
                                            $rows  = 1;
                                            while($rs=$result->fetch_object()){
                                                    echo '<tr>';
                                                    echo '<td class="text-center">'.$rows.'</td>';
                                                    echo '<td class="text-center">'.$rs->bname.'</td>';
                                                    echo '<td class="text-center">'.$rs->username.'</td>';
                                                    echo '<td class="text-center">'.$rs->fullname.'</td>';
                                                    echo '<td class="text-center">'.$rs->startDate.'</td>';
                                                    echo '<td class="text-center">'.$rs->endDate.'</td>';
                                                    echo '<td class="text-center">'.$rs->ddate.'</td>';
                                                    echo '<td class="text-center">'.$rs->tel.'</td>';
                                                    echo '<td class="text-center">'.$rs->bline.'</td>';
                                                        if($rs->st == 1){
                                                            echo '<td class="text-center booking-status" style="color:blue; font-weight:700;">รอการอนุมัติการจอง</td>';
                                                        }else if($rs->st == 2){
                                                            echo '<td class="text-center booking-status" style="color:green;font-weight:700;">อนุมัติการจองแล้ว</td>';
                                                        }else {
                                                            echo '<td class="text-center booking-status" style="color:red;font-weight:700;">ยกเลิกการจอง</td>';
                                                        }
                                                    echo '<td class="text-center"><i class="fa fa-pencil-square-o icon" aria-hidden="true" onclick="editBooking('.$rs->bid.')"></i></td>';
                                                    echo '</tr>';
                                                    $rows++;
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
