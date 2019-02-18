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
    <div class="container">
        <div class="row header">
            <div class="col text-center"><h2><?php echo $title; ?></h2></div>
        </div>
        <div class="row content">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:10%;">ลำดับที่</th>
                                <th class="text-center" style="width:40%;">รายการบริการ</th>
                                <th class="text-center" style="width:30%;">เวลา</th>
                                <th class="text-center" style="width:20%;">ราคา</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td class="text-center">นวดอโลม่าออยล์</td>
                                <td class="text-center">2 ชั่วโมง</td>
                                <td class="text-center">200 บาท</td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td class="text-center">นวดเท้า</td>
                                <td class="text-center">1 ชั่วโมง</td>
                                <td class="text-center">150 บาท</td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td class="text-center">นวดหน้า</td>
                                <td class="text-center">3 ชั่วโมง</td>
                                <td class="text-center">1500 บาท</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" >รวมเงิน</th>
                                <td class="text-center">1850 บาท</td>
                            </tr>
                            <tr>
                                <th colspan="3" >ภาษี 7%</th>
                                <td class="text-center">129.50 บาท</td>
                            </tr>
                            <tr>
                                <th colspan="3">รวมทั้งสิ้น</th>
                                <td class="text-center">1979.50 บาท</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
