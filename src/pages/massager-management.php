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
    include('../config/connect-db.php');
    echo '<title>'.$title.'</title>';
  ?>

<!-- DataTables JavaScript -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
  <!-- <script src="../assets/libs/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../assets/libs/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../assets/libs/vendor/datatables-responsive/dataTables.responsive.js"></script> -->
    
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
     <script>
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
                    <h1 class="page-header">จัดการข้อมูลผู้ใช้งาน</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
            <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            ตารางข้อมูลหมอนวด
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th>ชื่อผู้ใช้งาน</th>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>เบอร์โทร</th>
                                        <th>อีเมล์</th>
                                        <th>ไลน์</th>
                                        <th>ที่อยู่</th>
                                        <th>สถานะ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $sql= 'SELECT u.username,u.name,u.tel,u.email,u.line,u.address,s.status_name
                                        FROM hm_user u INNER JOIN hm_status s ON u.status_id = s.status_id 
                                        WHERE u.status_id =2';

                                    $result = $mysqli->query($sql);
                                    $total=$result->num_rows;
                                    while($rs=$result->fetch_object()){
                                        echo '<tr>';
                                        echo '<td>'.$rs->username.'</td>';
                                        echo '<td>'.$rs->name.'</td>';
                                        echo '<td>'.$rs->tel.'</td>';
                                        echo '<td>'.$rs->email.'</td>';
                                        echo '<td>'.$rs->line.'</td>';
                                        echo '<td>'.$rs->address.'</td>';
                                        echo '<td>'.$rs->status_name.'</td>';
                                        echo '</tr>';
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
