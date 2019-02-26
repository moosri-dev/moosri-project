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
                                            <th class="text-center">ชื่อพนักงาน</th>
                                            <th class="text-center">เวลาเข้างาน</th>
                                            <th class="text-center">เวลาออกงาน</th>
                                            <th class="text-center">สถานะทำงาน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        include('../config/connect-db.php');
                                        $sql= 'SELECT w.start_date as stDate, w.end_date as enDate, w.status as st, u.user_name as uname 
                                         FROM hm_works w INNER JOIN hm_user u ON w.user_id = u.user_id';
                                        
                                        if($stmt = $mysqli->prepare($sql)){
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            $rows = 1;
                                            while($rs=$result->fetch_object()){
                                                echo '<tr>';
                                                echo '<td class="text-center">'.$rows.'</td>';
                                                echo '<td class="text-center">'.$rs->uname.'</td>';
                                                echo '<td class="text-center">'.$rs->stDate.'</td>';
                                                echo '<td class="text-center">'.$rs->enDate.'</td>';
                                                echo '<td class="text-center">';
                                                if($rs->st == 1){
                                                    echo "<span style='color:green; font-weight:700;'>ยังไม่ได้ลงชื่อออกทำงาน</span>";
                                                }else{
                                                    echo "<span style='color:red; font-weight:700;'>ลงชื่อออกทำงานแล้ว</span>";
                                                }
                                                echo '</td>';
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
</html>
