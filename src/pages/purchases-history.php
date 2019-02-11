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
  <!-- <script src="../assets/libs/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../assets/libs/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../assets/libs/vendor/datatables-responsive/dataTables.responsive.js"></script> -->
    
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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            ตารางข้อมูลการขายสินค้า
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับที่</th>
                                        <th class="text-center">ชื่อสินค้า</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">ราคา</th>
                                        <th class="text-center">วันที่ขาย</th>
                                        <th class="text-center">ชื่อผู้ขาย</th>
                                        <th class="text-center">ชื่อผู้ซื้อ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    include('../config/connect-db.php');
                                    $sql= 'SELECT  
                                    p.product_name as pname, pur.pur_unit as unit
                                     , pur.product_price as price,pur.pur_date as date
                                     , u.user_name as username
                                     , c.cus_name   as cusname
                                  FROM  hm_purchases  pur 
                                    LEFT JOIN hm_product p ON  pur.product_id = p.product_id 
                                    LEFT JOIN hm_user u ON pur.user_id = u.user_id 
                                    LEFT JOIN hm_customer c ON pur.cus_id = c.cus_id';


                                    if($stmt = $mysqli->prepare($sql)){
                                        $stmt->execute();
                                        $result  = $stmt->get_result();
                                        $rows = 1;
                                        
                                        while($rs=$result->fetch_object()){
                                            echo '<tr>';
                                            echo '<td class="text-center">'.$rows.'</td>';
                                            echo '<td class="text-center">'.$rs->pname.'</td>';
                                            echo '<td class="text-right">'.$rs->unit.'</td>';
                                            echo '<td class="text-right">'.$rs->price.'</td>';
                                            echo '<td class="text-center">'.$rs->date.'</td>';
                                            echo '<td class="text-center">'.$rs->username.'</td>';
                                            echo '<td class="text-center">'.$rs->cusname.'</td>';
                                            echo '</tr>';
                                            $rows++;
                                        }
                                        $stmt->close();
                                    }else{
                                        echo "ERROR: SQL Excute Error.".$sql."<br>".$mysqli->error;
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
