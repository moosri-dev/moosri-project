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


    // if(isset($_POST['save'])){
    //     include('../config/connect-db.php');
    //     $image = $file_name_new;
    //     $pname = $_POST['pname'];
    //     $price = $_POST['price'];
    //     $unit = $_POST['unit'];
    //     $detail = $_POST['detail'];
    //     $user_id = $_SESSION['user_id'];
    //     $sql = "INSERT INTO 
    //     hm_product(product_name,product_detail,product_price,product_unit,product_img,user_id) 
    //     VALUES(?,?,?,?,?,?)";

    //     /* create a prepared statement */
    //     if($stmt = $mysqli->prepare($sql)){

    //         /* bind parameters for markers */
    //         $stmt->bind_param('ssiisi',$pname,$detail,$price,$unit,$image,$user_id);
            
    //         /* execute query */
    //         if($stmt->execute()){
    //             include ("../components/uploads.php");
    //             echo "Insert data success!";
    //             header('location: product-management.php');
    //         }else{
    //             echo "Error:".$sql."<br>".$mysqli->error;
    //             header('refresh:2;');
    //         }
    //         /* close statement */
    //         $stmt->close();
            
    //     }else{
    //         echo "Error:".$sql."<br>".$mysqli->error;
    //         header('refresh:2;');
    //     }
    //     $mysqli->close();

    //     exit(0);
    // }
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
                            <form method="post">
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
                                    <div class="footer">
                                        <button type="submit" class="btn btn-lg btn-primary" id="save" disabled>บันทึกข้อมูล</button>
                                    </div>
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
        $pid = array();
        $pname = array();
        $price = array();
        while($rs=$result->fetch_object()){
            array_push($pid,$rs->pid);
            array_push($pname,$rs->pname);
            array_push($price,$rs->price);
        }$stmt->close();
    }$mysqli->close();
    echo '<script type="text/javascript">';
    echo 'var pid = ' . json_encode($pid) . ';';
    echo 'var pname = ' . json_encode($pname) . ';';
    echo 'var priceValue = ' . json_encode($price) . ';';
    echo '</script>';
?>

<script type="text/javascript">

    var table = document.getElementById("myTable");
    var rowNum = 0;
    var optionsAsString = "";

    for(var i = 0; i < pid.length; i++) {
        optionsAsString += "<option value='" + pid[i] + "'>" + pname[i] + "</option>";
    }
    function addItem(){
        let row = table.insertRow();
        row.className = "text-center";
        row.setAttribute("id",rowNum);
        let sequence = row.insertCell(0);
        let productName = row.insertCell(1);
        let quantity = row.insertCell(2);
        let price = row.insertCell(3);
        let total = row.insertCell(4);
        let del = row.insertCell(5);

        ++rowNum;
        sequence.setAttribute("style","line-height: 35px;");   
        sequence.innerHTML = rowNum;
        productName.innerHTML = '<select name="product[]" class="custom-select" onchange="selectChangeValue(this)" required>'+optionsAsString+'</select>';
        quantity.innerHTML = '<input type="number" name="unit[]" id="unit" class="form-control" value="0" onchange="changeValue(this)" min="0" required>';
        price.innerHTML = '<input type="number" name="price[]" id="price" class="form-control" value="'+priceValue[0]+'" readonly required>';
        total.innerHTML = '<input type="number" name="total[]" id="total" class="form-control" value="0" readonly required>';

        del.setAttribute("style","line-height: 35px;");   
        del.innerHTML = '<i class="fa fa-ban icon" aria-hidden="true" onclick="deleteItem(this)"></i>';

        document.getElementById("save").disabled = false;
    }
    function selectChangeValue(param){
        let row = param.parentElement.parentElement;
        let unit = row.children[2].children[0];
        let price = row.children[3].children[0];
        let total = row.children[4].children[0];
        // console.log(product.options[product.selectedIndex].value);
        console.log(price);
        price.value = priceValue[param.selectedIndex];
        total.value = price.value * unit.value;
    }
    function changeValue(param){
        let row = param.parentElement.parentElement;
        let unit = param;
        let price = row.children[3].children[0];
        let total = row.children[4].children[0];
        total.value = price.value * unit.value;
    }
    function deleteItem(param){
        let row = param.parentElement.parentElement;
        table.deleteRow(row.rowIndex);
        if(table.rows.length == 1){
            document.getElementById("save").disabled = true;
        }
    }
</script>
</body>
</html>
