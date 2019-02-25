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
 
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myTable').DataTable({
                responsive: true
            });
        });

        function deleteUser(pid,pname){
            if(confirm("ยืนยันการลบข้อมูลสินค้า: "+pname)){
                $.post('pages/delete-product.php','pid='+pid,function(response){
                if(response){
                alert("Delete Product Success.");
                location.reload();
                }else{
                    alert('Delete Product Failed.');
                }
                });
            }
        }
        function editUser(pid){
            let url = "pages/edit-product.php?pid="+pid;
            window.location.href = url;
        }
    </script>
</head>

<body>
    <div id="wrapper">
        <?php include('../components/menu.php'); ?>
        <div id="page-wrapper">

            <div class="row sub-header">
                <div class="col-lg-12">
                    <h1 class="page-header">จัดการข้อมูลสินค้า</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
            <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            ตารางข้อมูลรายการสินค้า
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width:5%">#</th>
                                        <th class="text-center" style="width:10%">รูปสินค้า</th>
                                        <th class="text-center" style="width:15%">ชื่อสินค้า</th>
                                        <th class="text-center" style="width:25%">รายละเอียดสินค้า</th>
                                        <th class="text-center" style="width:10%">ราคา/หน่วย</th>
                                        <th class="text-center" style="width:10%">จำนวน</th>
                                        <th class="text-center" style="width:15%">ชื่อผู้นำเข้าสินค้า</th>
                                        <th class="text-center" style="width:5%">แก้ไข</th>
                                        <th class="text-center" style="width:5%">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    include('../config/connect-db.php');
                                    $sql= 'SELECT p.product_id as pid, p.product_name as pname
                                                , p.product_detail as detail, p.product_price as price
                                                , p.product_unit as unit, p.product_img as image
                                                , u.user_name as username
                                            FROM hm_product p INNER JOIN hm_user u ON p.user_id = u.user_id'; 

                                    if($stmt = $mysqli->prepare($sql)){
                                        $stmt->execute();
                                        $result  = $stmt->get_result();
                                        $rows = 1;
                                        
                                        while($rs=$result->fetch_object()){
                                            echo '<tr>';
                                            echo '<td class="text-center">'.$rows.'</td>';
                                            echo '<td class="text-center"><img src="'.'uploads/'.str_replace("","uploads/",$rs->image).'" class="item image"/></td>';
                                            echo '<td class="text-center">'.$rs->pname.'</td>';
                                            echo '<td class="text-center">'.$rs->detail.'</td>';
                                            echo '<td class="text-center">'.$rs->price.'</td>';
                                            echo '<td class="text-center">'.$rs->unit.'</td>';
                                            echo '<td class="text-center">'.$rs->username.'</td>';
                                            echo '<td class="text-center" ><i class="fa fa-pencil-square-o icon" aria-hidden="true" onclick="editUser('.$rs->pid.')"></i></td>';
                                            echo '<td class="text-center" ><i class="fa fa-ban icon" aria-hidden="true" onclick="deleteUser('.$rs->pid.','."'$rs->pname'".')"></i></td>';
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
