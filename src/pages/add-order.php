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
                            <form>
                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="inputUsername">รายละเอียดรายการสินค้า<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="detail" class="form-control" placeholder='รายละเอียดรายการสินค้า' maxlength='50' required/>
                                    </div>
                                </div>
                                <div class="content">
                                    <button type="button" class="btn btn-md btn-primary" style="margin-bottom: 5px;" onclick="addItem()">เพิ่มรายการขายสินค้า</button>
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="myTable">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width:10%">#</th>
                                                <th class="text-center" style="width:25%">ชื่อสินค้า</th>
                                                <th class="text-center" style="width:15%">จำนวน</th>
                                                <th class="text-center" style="width:15%">ราคา/หน่วย</th>
                                                <th class="text-center" style="width:25%">รวม</th>
                                                <th class="text-center" style="width:10%">ลบ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <!-- /.table-responsive -->
                                </div>
                            </form> 
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

    <?php 
    include('../config/connect-db.php');
    $sql= 'SELECT product_id as pid, product_name as pname, product_price as price, product_unit as unit 
        FROM hm_product';

    if($stmt = $mysqli->prepare($sql)){
        $stmt->execute();
        $result  = $stmt->get_result();
        $rows = 1;
        while($rs=$result->fetch_object()){
?>
<script type="text/javascript">
    var rowNum = 1;
    function addItem(){
        var table = document.getElementById("myTable");
        var row = table.insertRow();
        row.className = "text-center";

        var sequence = row.insertCell(0);
        var productName = row.insertCell(1);
        var quantity = row.insertCell(2);
        var price = row.insertCell(3);
        var total = row.insertCell(4);
        var del = row.insertCell(5);

        sequence.innerHTML = rowNum;
        productName.innerHTML = '<select name="product"><option value="'.<?php echo $rs->pid ?>.'">'.<?php echo $rs->pname ?>.'</option></select>';
        quantity.innerHTML = '<input type="number" name="unit" class="form-control">';
        price.innerHTML = "NEW CELL4";
        total.innerHTML = "NEW CELL5";

        del.innerHTML = '<i class="fa fa-ban icon" aria-hidden="true"></i>';
        rowNum++;
    }
</script>
<?php
    }$stmt->close();
}$mysqli->close();
?>

</body>
</html>
