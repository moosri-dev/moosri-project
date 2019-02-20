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

        function deleteBooking(id,bookingName){
            if(confirm("ยืนยันการลบข้อมูลรายการนวดนี้: "+bookingName)){
                $.post('pages/delete-booking-details.php','id='+id,function(response){
               if(response){
                alert("Delete Booking Success.");
                location.reload();
               }else{
                   alert('Delete Booking Failed.');
                }
             });
            }
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
                            <table width="100%" class="table table-striped table-bordered table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width:5%">#</th>
                                        <th class="text-center" style="width:15%">รายการบริการ</th>
                                        <th class="text-center" style="width:15%">ชื่อหมอนวด</th>
                                        <th class="text-center" style="width:15%">ชื่อลูกค้า</th>
                                        <th class="text-center" style="width:10%">เวลาเริ่มต้น</th>
                                        <th class="text-center" style="width:10%">เวลาสิ้นสุด</th>
                                        <th class="text-center" style="width:10%">เบอร์โทร</th>
                                        <th class="text-center" style="width:10%">ไลน์</th>
                                        <th class="text-center" style="width:5%">แก้ไข</th>
                                        <th class="text-center" style="width:5%">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    include('../config/connect-db.php');
                                    $sql= 'SELECT d.bk_id as bid, d.bk_fullname as fullname, d.bk_tel as tel
                                    , d.bk_line as bline, d.bk_time as startDate, d.bk_time_end as endDate
                                    , u.user_id as uid, u.user_name as username, b.bk_name as bname 
                                            FROM hm_booking_details d INNER JOIN hm_booking b ON d.bk_id_fk = b.bk_id
                                            INNER JOIN hm_user u ON d.hm_user_id = u.user_id';
                                    
                                    if($stmt = $mysqli->prepare($sql)){
                                        $stmt->execute();
                                        $result  = $stmt->get_result();
                                        while($rs=$result->fetch_object()){
                                            echo '<tr>';
                                            echo '<td class="text-center"><a href="pages/massager-schedule.php?id='.$rs->uid.'"><i class="fa fa-eye" aria-hidden="true"></i></a></td>';
                                            echo '<td class="text-center">'.$rs->bname.'</td>';
                                            echo '<td class="text-center">'.$rs->username.'</td>';
                                            echo '<td class="text-center">'.$rs->fullname.'</td>';
                                            echo '<td class="text-center">'.$rs->startDate.'</td>';
                                            echo '<td class="text-center">'.$rs->endDate.'</td>';
                                            echo '<td class="text-center">'.$rs->tel.'</td>';
                                            echo '<td class="text-center">'.$rs->bline.'</td>';
                                            echo '<td class="text-center"><i class="fa fa-pencil-square-o icon" aria-hidden="true" onclick="editBooking('.$rs->bid.')"></i></td>';
                                            echo '<td class="text-center"><i class="fa fa-ban icon" aria-hidden="true" onclick="deleteBooking('.$rs->bid.','."'$rs->bname'".')"></i></td>';
                                            echo '</tr>';
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
