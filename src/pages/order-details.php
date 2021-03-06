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
                    <h1 class="page-header">จัดการข้อมูลการขายสินค้า</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
            <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            ตารางข้อมูลรายละเอียดรายการขายสินค้า
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width:10%">#</th>
                                        <th class="text-center" style="width:40%">รายการสินค้า</th>
                                        <th class="text-center" style="width:25%">จำนวน</th>
                                        <th class="text-center" style="width:25%">ราคา</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    include('../config/connect-db.php');
                                    $sql= 'SELECT p.product_name as pname, d.quantity,d.price 
                                    FROM hm_order_details d INNER JOIN hm_product p ON d.product_id = p.product_id 
                                    WHERE d.order_id = ?'; 
                                    

                                    if($stmt = $mysqli->prepare($sql)){
                                        $stmt->bind_param('i',$_GET['oid']);
                                        $stmt->execute();
                                        $result  = $stmt->get_result();
                                        $row = 1;
                                        while($rs=$result->fetch_object()){
                                            echo '<tr>';
                                            echo '<td class="text-center">'.$row.'</td>';
                                            echo '<td class="text-center">'.$rs->pname.'</td>';
                                            echo '<td class="text-center">'.$rs->quantity.'</td>';
                                            echo '<td class="text-center">'.$rs->price.'</td>';
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
                    <a class="btn btn-lg btn-primary" href="pages/order-management.php"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbspย้อนกลับ</a>
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
