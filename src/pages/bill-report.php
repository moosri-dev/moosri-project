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

    include('../config/connect-db.php');

    $sql= 'SELECT o.order_id as oid, o.order_details as odetail
    ,o.price_total as pt, o.quantity_total as qt
    , o.create_date as cd, u.user_name as uname 
    FROM hm_orders o INNER JOIN hm_user u ON o.user_id = u.user_id 
    WHERE order_id = ?';  
 

    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("i",$_GET['id']);
        $stmt->execute();
        $result  = $stmt->get_result();
        while($rs=$result->fetch_object()){
            $oid = $rs->oid;
            $odetail = $rs->odetail;
            $pt = $rs->pt;
            $qt = $rs->qt;
            $cd = $rs->cd;
            $uname = $rs->uname;
        }
        $stmt->close();
    }
   
  ?>
  <script type="text/javascript">
    function printOrder(){
        document.getElementById("btnPrint").style.display = "none";
        document.getElementById("btnBack").style.display = "none";

        window.print();
    }
    var beforePrint = function() {
        console.log('Functionality to run before printing.');
    };

    var afterPrint = function() {
        console.log('Functionality to run after printing');
        document.getElementById("btnPrint").style.display = "inline-block";
        document.getElementById("btnBack").style.display = "inline-block";
    };
    if (window.matchMedia) {
        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function(mql) {
            if (mql.matches) {
                beforePrint();
            } else {
                afterPrint();
            }
        });
    }
    window.onbeforeprint = beforePrint;
    window.onafterprint = afterPrint;
  </script>
</head>

<body>
    <div class="container">
        <div class="row header">
            <div class="col text-center bd-bottom"><h3><?php echo $title; ?></h3></div>
        </div>
        <div class="row content">
            <div class="col">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="order-header">
                                <span> เลขที่ใบเสร็จ:</span><span class="order-value"> <?php echo $oid;?></span>
                                <p></p>
                                <span>ชื่อผู้ขาย:</span><span class="order-value"> <?php echo $uname;?></span>
                                &nbsp&nbsp&nbsp&nbsp
                                <span>วันที่ขาย:</span><span class="order-value"> <?php echo $cd;?></span>
                            </div>
                        </div>
                        <div class="col-md-6 text-right print-order">
                            <button class="btn btn-lg  btn-success" id="btnPrint" type="button" onclick="printOrder()"><i class="fa fa-file-pdf-o icon" aria-hidden="true" style="color: floralwhite;"></i>&nbsp&nbsp&nbsp&nbsp พิมพ์ใบเสร็จ</button>
                        </div>   
                    </div> 
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:10%;">ลำดับที่</th>
                                <th class="text-center" style="width:40%;">รายการสินค้า</th>
                                <th class="text-center" style="width:20%;">จำนวน</th>
                                <th class="text-center" style="width:30%;">ราคา</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql= 'SELECT p.product_name as pname, od.quantity as qt, od.price as price  
                                FROM hm_order_details od  INNER JOIN hm_product p ON od.product_id = p.product_id 
                                WHERE od.order_id = ?';  
                             
                         
                                if($stmt = $mysqli->prepare($sql)){
                                    $stmt->bind_param("i",$_GET['id']);
                                    $stmt->execute();
                                    $result  = $stmt->get_result();
                                    $rows = 1;
                                    while($rs=$result->fetch_object()){
                                        echo '<tr>';
                                        echo '<td class="text-center">'.$rows.'</td>';
                                        echo '<td class="text-center">'.$rs->pname.'</td>';
                                        echo '<td class="text-center">'.$rs->qt.' ชิ้น</td>';
                                        echo '<td class="text-center">'.number_format(((float)$rs->price*(float)$rs->qt), 2).' บาท</td>';
                                        echo '</tr>';
                                        $rows++;
                                    }
                                    $stmt->close();
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" >รวม</th>
                                <td class="text-center"><?php echo $qt.' ชิ้น';?></td>
                                <td class="text-center"><?php echo number_format($pt, 2).' บาท';?></td>
                            </tr>
                            <tr>
                                <th colspan="3" >ภาษี 7%</th>
                                <td class="text-center"><?php echo number_format(((float)$pt*7/100), 2).' บาท';?></td>
                            </tr>
                            <tr>
                                <th colspan="3">รวมเป็นเงินทั้งสิ้น</th>
                                <td class="text-center"><?php echo number_format((float)$pt+((float)$pt*7/100), 2).' บาท';?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-lg btn-primary" id="btnBack" href="pages/order-management.php"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbsp ย้อนกลับ</a>
            </div>
        </div>
    </div>
</body>
        <?php
         $mysqli->close();
        ?>
</html>
