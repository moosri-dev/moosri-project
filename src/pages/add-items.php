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


    if(isset($_POST['save'])){
        include('../config/connect-db.php');
        $pid = $_POST['pid'];
        $price = $_POST['price'];
        $unit = $_POST['unit'];
        $total = $_POST['total'];
        $detail =  $_POST['detail'];
        $sumTotal = 0;
        $sumUnit = 0;
        $createDate = $_POST['createDate'];
        $userId = $_SESSION['user_id'];

        $tmpPid = $pid[0];
   
        $pidList = array($tmpPid);
        $pidSort = array();
        foreach($pid as $p){
            array_push($pidSort,$p);
        }
        sort($pidSort);
        for($i =0; $i<sizeof($pidSort); $i++){
            if($pidSort[$i] != $tmpPid){
                array_push($pidList,$pidSort[$i]);
                $tmpPid = $pidSort[$i];
            }
        }
        $quanlityList = array();
        foreach($pidList as $p){
            $sumQuantity = 0;
            for($i =0; $i<sizeof($pid); $i++){
                if($pid[$i] == $p){
                    $sumQuantity+= $unit[$i];
                }
            }
            $sql = 'SELECT product_id as pid, product_unit as punit,product_name as pname FROM hm_product WHERE product_id = ?';
                if($stmt = $mysqli->prepare($sql)){
                    $stmt->bind_param('i',$p);
                    if($stmt->execute()){
                        $result  = $stmt->get_result();
                        while($rs=$result->fetch_object()){
                            if((int)$sumQuantity > (int)$rs->punit){
                                echo " จำนวนสินค้า: ".$rs->pname." มีไม่เพียงพอ!!!";
                                header('refresh:10;');
                            }else{
                                $resultUnit = (int)$rs->punit - (int)$sumQuantity;
                                $sql2='UPDATE hm_product SET product_unit = ? WHERE product_id = ?';
                                if($stmt2 = $mysqli->prepare($sql2)){
                                    $stmt2->bind_param('ii',$resultUnit,$p);
                                    if(!$stmt2->execute()){
                                        echo " ERROR: ".$sql2."<br>".$mysqli->error;
                                    }
                                    $stmt2->close();
                                }
                            }
                        }
                    }
                    $stmt->close();
                }
            array_push($quanlityList,$sumQuantity);
        }
        
        foreach($total as $t){
            $sumTotal += $t;
        }
        foreach($unit as $u){
            $sumUnit += $u;
        }

        $sql = "INSERT INTO hm_orders(order_details,user_id,price_total,quantity_total,create_date) 
        VALUES(?,?,?,?,?)";
        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param('sidis',$detail,$userId,$sumTotal,$sumUnit,$createDate);

            if($stmt->execute()){
                $oid = $mysqli->insert_id;
                for($i = 0;$i<sizeof($price);$i++){
                    $sql2= "INSERT INTO hm_order_details(order_id,product_id,quantity,price) 
                        VALUES(?,?,?,?)";
                    if($stmt2 = $mysqli->prepare($sql2)){
        
                        $stmt2->bind_param('iiid',$oid,$pid[$i],$unit[$i],$price[$i]);
                        
                        if($stmt2->execute()){
                            echo "Insert data success!<br>";
                            header('Refresh:5;url=order-management.php');
                        }else{
                        echo "Error:".$sql2."<br>".$mysqli->error;
                        header('refresh:5;');
                        }
                        /* close statement */
                        $stmt2->close();
                        
                    }else{
                        echo "Error:".$sql."<br>".$mysqli->error;
                        header('refresh:5;');
                    }
                }
                $stmt->close();
            }else{
                echo "Error:".$sql."<br>".$mysqli->error;
                header('refresh:5;');
            }
            $mysqli->close();
        }
        exit(0);
    }
  ?>
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
            <div class="col-md-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            ตารางเพิ่มข้อมูลรายการขายสินค้า
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form method="post">
                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="inputDetails">รายละเอียดรายการสินค้า<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="detail" class="form-control" placeholder='รายละเอียดรายการสินค้า' maxlength='50' required/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="inputCreateDate">วันที่ขายสินค้า<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date" name="createDate" class="form-control" min="2019-01-01" max="2030-12-31" maxlength='50' onkeydown="return false" required/>
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
                                        <button type="submit" class="btn btn-lg btn-primary" name="save" id="save" disabled>บันทึกข้อมูล</button>
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
    $sql= 'SELECT product_id as pid, product_name as pname, product_price as price, product_unit as amount 
        FROM hm_product';
    if($stmt = $mysqli->prepare($sql)){
        $stmt->execute();
        $result  = $stmt->get_result();
        $pid = array();
        $pname = array();
        $price = array();
        $amount = array();
        while($rs=$result->fetch_object()){
            array_push($pid,$rs->pid);
            array_push($pname,$rs->pname);
            array_push($price,$rs->price);
            array_push($amount,$rs->amount);
        }$stmt->close();
    }$mysqli->close();
    echo '<script type="text/javascript">';
    echo 'var pid = ' . json_encode($pid) . ';';
    echo 'var pname = ' . json_encode($pname) . ';';
    echo 'var priceValue = ' . json_encode($price) . ';';
    echo 'var amount = ' . json_encode($amount) . ';';
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
        productName.innerHTML = '<select name="pid[]" id="pid'+rowNum+'" class="custom-select" onchange="selectChangeValue(this)" required>'+optionsAsString+'</select>';
        quantity.innerHTML = '<input type="number" name="unit[]" id="unit" class="form-control" value="1" onchange="changeValue(this)" onkeyup="myKeyChange(event,this)" min="1" max="'+amount[0]+'" required>';
        price.innerHTML = '<input type="number" name="price[]" id="price" class="form-control" value="'+priceValue[0]+'" readonly required>';
        total.innerHTML = '<input type="number" name="total[]" id="total" class="form-control" value="'+priceValue[0]+'" readonly required>';

        del.setAttribute("style","line-height: 35px;");   
        del.innerHTML = '<i class="fa fa-ban icon" aria-hidden="true" onclick="deleteItem(this)"></i>';

        document.getElementById("save").disabled = false;
    }
    function selectChangeValue(param){
        let row = param.parentElement.parentElement;
        let unit = row.children[2].children[0];
        let price = row.children[3].children[0];
        let total = row.children[4].children[0];

        price.value = priceValue[param.selectedIndex];
        unit.value = 1;
        total.value = price.value * unit.value;
        unit.setAttribute('max',amount[param.selectedIndex]);
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
    function myKeyChange(event,param){
        if(parseInt(param.value) > parseInt(param.max)){
            event.preventDefault();
            param.value = param.max;
        }else if(parseInt(param.value) < parseInt(param.min) ||param.value == "" ){
            event.preventDefault();
            param.value = param.min;
        }
    }
</script>
</body>
</html>
