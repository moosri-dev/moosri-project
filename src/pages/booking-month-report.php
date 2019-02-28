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

    $monthDate = $_POST['monthOfYear'];
    $spDate = explode('-',$monthDate);

    $month = $spDate[1];
    $year = (int)$spDate[0]+543;

    $monthOfYear = $month."/".$year;


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
                    <div class="row print-booking">
                        <div class="col-md-6">
                            <div class="order-header" style="padding:unset;padding-top: 25px;">
                                <span>รายงานประจำเดือนที่: </span><span class="order-value"> <?php echo $monthOfYear;?></span>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-lg  btn-success" id="btnPrint" type="button" onclick="printOrder();"><i class="fa fa-file-pdf-o icon" aria-hidden="true" style="color: floralwhite;"></i>&nbsp&nbsp&nbsp&nbsp พิมพ์ใบเสร็จ</button>
                        </div>   
                    </div> 
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">ลำดับที่</th>
                                <th class="text-center">รายการนวด</th>
                                <th class="text-center">เวลาเริ่มต้น</th>
                                <th class="text-center">เวลาสิ้นสุด</th>
                                <th class="text-center">วันที่</th>
                                <th class="text-center">ชื่อลูกค้า</th>
                                <th class="text-center">ราคา</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql= 'SELECT d.bk_fullname as cusname, d.bk_time as startTime
                                , d.bk_time_end as endTime
                                ,d.bk_date as ddate, b.bk_name as bname, b.bk_cost as cost 
                                FROM hm_booking b INNER JOIN hm_booking_details d ON b.bk_id = d.bk_id_fk 
                                WHERE  d.status = ? AND  d.bk_date LIKE  ?';  
                             
                         
                                if($stmt = $mysqli->prepare($sql)){
                                    $status = 2;
                                    $monthOfYear= "%".$monthOfYear;
                                    $stmt->bind_param("is",$status,$monthOfYear);
                                    $stmt->execute();
                                    $result  = $stmt->get_result();
                                    $rows = 1;
                                    $cTotal = 0;
                                    while($rs=$result->fetch_object()){
                                        $cTotal += $rs->cost;
                                        echo '<tr>';
                                        echo '<td class="text-center">'.$rows.'</td>';
                                        echo '<td class="text-center">'.$rs->bname.'</td>';
                                        echo '<td class="text-center">'.$rs->startTime.'</td>';
                                        echo '<td class="text-center">'.$rs->endTime.'</td>';
                                        echo '<td class="text-center">'.$rs->ddate.' </td>';
                                        echo '<td class="text-center">'.$rs->cusname.'</td>';
                                        echo '<td class="text-center">'.number_format((float)$rs->cost, 2).' บาท</td>';
                                        echo '</tr>';
                                        $rows++;
                                    }
                                    $stmt->close();
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6" >รวม</th>
                                <td class="text-center"><?php echo number_format($cTotal, 2).' บาท';?></td>
                            </tr>
                            <tr>
                                <th colspan="6" >ภาษี 7%</th>
                                <td class="text-center"><?php echo number_format(((float)$cTotal*7/100), 2).' บาท';?></td>
                            </tr>
                            <tr>
                                <th colspan="6">รวมเป็นเงินทั้งสิ้น</th>
                                <td class="text-center"><?php echo number_format((float)$cTotal+((float)$cTotal*7/100), 2).' บาท';?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-lg btn-primary" id="btnBack" href="pages/user-booking-management.php"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbsp ย้อนกลับ</a>
            </div>
        </div>
    </div>
</body>
        <?php
         $mysqli->close();
        ?>
</html>
