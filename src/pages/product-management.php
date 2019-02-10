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

        function deleteUser(id,username){
            if(confirm("ยืนยันการลบข้อมูลผู้ใช้: "+username)){
                $.post('pages/delete-user.php','userId='+id,function(response){
               if(response){
                alert("Delete User Success.");
                location.reload();
               }else{
                   alert('Delete User Failed.');
                }
             });
            }
        }
        function editUser(id){
            let url = "pages/edit-user.php?id="+id;
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
                    <h1 class="page-header">จัดการข้อมูลผู้ใช้งาน</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
            <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            ตารางข้อมูลเจ้าหน้าที่ดูแลระบบ
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับที่</th>
                                        <th class="text-center">ชื่อสินค้า</th>
                                        <th class="text-center">รายละเอียดสินค้า</th>
                                        <th class="text-center">ราคา/หน่วย</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">แก้ไขข้อมูล</th>
                                        <th class="text-center">ลบข้อมูล</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    include('../config/connect-db.php');
                                    $sql= 'SELECT product_id as pid, product_name as pname
                                                , product_detail as detail, product_price as price
                                                , product_unit as unit, product_img as image 
                                            FROM hm_product'; 

                                    if($stmt = $mysqli->prepare($sql)){
                                        $stmt->execute();
                                        $result  = $stmt->get_result();
                                        $rows = 1;
                                        
                                        while($rs=$result->fetch_object()){
                                            echo '<tr>';
                                            echo '<td class="text-center">'.$rows.'</td>';
                                            echo '<td>'.$rs->pname.'</td>';
                                            echo '<td>'.$rs->detail.'</td>';
                                            echo '<td class="text-right">'.$rs->price.'</td>';
                                            echo '<td class="text-right">'.$rs->unit.'</td>';
                                            echo '<td class="text-center" onclick="editUser('.$rs->pid.')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></td>';
                                            echo '<td class="text-center" onclick="deleteUser('.$rs->pid.','."'$rs->pname'".')"><i class="fa fa-ban" aria-hidden="true"></i></td>';
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
