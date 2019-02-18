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
                    <h1 class="page-header">ประวัติข้อมูลการขายสินค้า</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
            <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            ตารางข้อมูลรายการขายสินค้า
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width:10%">เพิ่มเติม</th>
                                        <th class="text-center" style="width:15%">เลขที่ใบเสร็จ</th>
                                        <th class="text-center" style="width:25%">รายละเอียด</th>
                                        <th class="text-center" style="width:15%">ราคา</th>
                                        <th class="text-center" style="width:20%">ผู้ขาย</th>
                                        <th class="text-center" style="width:15%">วันที่ขาย</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    include('../config/connect-db.php');
                                    $sql= 'SELECT o.order_id as id,o.order_details as details
                                    ,o.total as total,u.user_name as name,o.create_date as date 
                                    FROM hm_orders o LEFT JOIN hm_user u ON o.user_id = u.user_id';  
                                    

                                    if($stmt = $mysqli->prepare($sql)){
                                        $stmt->execute();
                                        $result  = $stmt->get_result();
                                        
                                        while($rs=$result->fetch_object()){
                                            echo '<tr>';
                                            echo '<td class="text-center"><a href="pages/order-details.php?oid='.$rs->id.'"><i class="fa fa-eye" aria-hidden="true"></i></a></td>';
                                            echo '<td class="text-center">'.$rs->id.'</td>';
                                            echo '<td class="text-center">'.$rs->details.'</td>';
                                            echo '<td class="text-center">'.$rs->total.'</td>';
                                            echo '<td class="text-center">'.$rs->name.'</td>';
                                            echo '<td class="text-center">'.$rs->date.'</td>';
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

</html>
