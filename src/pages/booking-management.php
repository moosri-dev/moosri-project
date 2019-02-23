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
            if(confirm("ยืนยันการลบข้อมูลรายการบริการนี้: "+bookingName)){
                $.post('pages/delete-booking.php','id='+id,function(response){
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
            let url = "pages/edit-booking.php?id="+id;
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
                    <h1 class="page-header">จัดการข้อมูลรายการนวด</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
            <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            ตารางข้อมูลรายการนวด
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width:5%">#</th>
                                        <th class="text-center" style="width:20%">รายการบริการ</th>
                                        <th class="text-center" style="width:20%">รายละเอียด</th>
                                        <th class="text-center" style="width:15%">เวลา/นาที</th>
                                        <th class="text-center" style="width:20%">ค่าบริการ</th>
                                        <th class="text-center" style="width:5%">แก้ไข</th>
                                        <th class="text-center" style="width:5%">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    include('../config/connect-db.php');
                                    $sql= 'SELECT bk_id as bid, bk_name as bname, bk_detail as details, bk_time as btime, bk_cost as cost 
                                            FROM hm_booking';
                                    

                                    if($stmt = $mysqli->prepare($sql)){
                                        $stmt->execute();
                                        $result  = $stmt->get_result();
                                        $rows= 1;
                                        while($rs=$result->fetch_object()){
                                            echo '<tr>';
                                            echo '<td class="text-center">'.$rows.'</td>';
                                            echo '<td class="text-center">'.$rs->bname.'</td>';
                                            echo '<td class="text-center">'.$rs->details.'</td>';
                                            echo '<td class="text-center">'.$rs->btime.'</td>';
                                            echo '<td class="text-center">'.$rs->cost.'</td>';
                                            echo '<td class="text-center"><i class="fa fa-pencil-square-o icon" aria-hidden="true" onclick="editBooking('.$rs->bid.')"></i></td>';
                                            echo '<td class="text-center"><i class="fa fa-ban icon" aria-hidden="true" onclick="deleteBooking('.$rs->bid.','."'$rs->bname'".')"></i></td>';
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
