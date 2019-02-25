<?php
if (!isset($_SESSION)) {session_start();}
include "../config/connect-db.php";

//select user all
$stmt = $mysqli->prepare("SELECT * FROM hm_user WHERE status_id != 1");
$stmt->execute();
$r = $stmt->get_result();
$countAll = $r->num_rows;

//select massage_list
$ms = $mysqli->prepare("SELECT * FROM hm_booking");
$ms->execute();
$list = $ms->get_result();
$n = 0;
//add data booking
if (isset($_POST['save'])) {
    $name = $_POST['username'];
    $tel = $_POST['tel'];
    $line = $_POST['line'];
    $bkid = $_POST['bkid'];
    $empid = $_POST['empid'];
    $timeS = $_POST['timeStart'];
    $timeE = $_POST['timeEnd'];
    $gDate = $_POST['bk_date'];
    $d = substr($gDate,0,2);
    $m = substr($gDate,3,2);
    $y = substr($gDate,6,5);
    $date = $y.'-'.$m.'-'.$d;
    //หาเวลาที่นวดตาม ชั่วโมงบริการ
    $ms2 = $mysqli->prepare("SELECT bk_time FROM hm_booking WHERE bk_id = ?");
    $ms2->bind_param("i", $bkid);
    $ms2->execute();
    $list2 = $ms2->get_result();

    //check ก่อนว่า หมอนวดที่ถูกจอง ว่าเวลานี้ไหม
    if ($qry = $mysqli->prepare("SELECT bk.*, ur.* FROM hm_booking_details bk INNER JOIN hm_user ur ON bk.hm_user_id = ur.user_id WHERE  bk_time_end <= ? AND bk.hm_user_id = ?")) {
        $qry->bind_param('si', $timeE, $empid);
        $qry->execute();
        $listChk = $qry->get_result();
        if ($listChk->num_rows != 0) {
            $n = $listChk->num_rows;
        } else {
            //Insert ข้อมูลลงดาต้าเบส
            $sts = 1;
            $sql = "INSERT INTO hm_booking_details(bk_fullname, bk_tel, bk_line, bk_id_fk, hm_user_id, bk_time,bk_time_end,bk_date,status) VALUES(?,?,?,?,?,?,?,?,?)";
            if ($q = $mysqli->prepare($sql)) {
                $q->bind_param('sssiisssi', $name, $tel, $line, $bkid, $empid, $timeS, $timeE, $date, $sts);
                $q->execute();
            } else {
                echo "Error:" . $sql . "<br>" . $mysqli->error;
            }
        }
    }
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <meta http-equiv="refresh" content="0;url="> -->
    <title>ศูนย์นวดแผนไทยหมู่สี</title>
    <!--    Style Sheet -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="../assets/css/style.css"> -->
    <link rel="stylesheet" href="../assets/css/booking.css">
    <link rel="stylesheet" href="../assets/css/datepicker.css">

</head>

<body>
    <div class="header">
        <?php include "../components/header.php";?>
    </div>
    <div class="content">
        <div class="row body_c">
            <div class="col-md-4 card_c card" style="width: 18rem;">
                <div class="row">
                    <div class="imame-user" style="margin:10px 1px 10px 10px;">
                        <h3><i class="fas fa-info-circle"></i>&nbsp;&nbsp;รายละเอียด</h3>
                        <div class="container">
                            <label for="topic">
                                <i class="fas fa-map-marker"></i>
                                &nbsp;สถานะหมอนวด</label>
                            <ul>
                                <li>หมอนวดทั้งหมด <?='<b>' . $countAll . '</b>'?> คน</li>
                                <li>หมอนวดที่กำลังบริการ <?='<b>' . $countAll . '</b>'?> คน</li>
                                <li>หมอนวดที่พร้อมบริการ <?='<b>' . $countAll . '</b>'?> คน</li>
                            </ul>
                        </div>
                        <div class="container">
                            <label for="topic">
                                <i class="fas fa-map-marker"></i>&nbsp;รายชื่อบริการทั้งหมด</label>
                            <ul>
                                <li>
                                    นวดอโรมาออยล์
                                    <ul>
                                        <li>เวลา 1.5 ชั่วโมง</li>
                                        <li>ราคา 450 บาท</li>
                                    </ul>
                                </li>
                                <li>นวดน้ำมัน
                                    <ul>
                                        <li>เวลา 1.5 ชั่วโมง</li>
                                        <li>ราคา 450 บาท</li>
                                    </ul>
                                </li>
                                <li>นวดแผนไทย
                                    <ul>
                                        <li>เวลา 1.5 ชั่วโมง</li>
                                        <li>ราคา 450 บาท</li>
                                    </ul>
                                </li>
                                <li>นวดฝาเท้า
                                    <ul>
                                        <li>เวลา 1.5 ชั่วโมง</li>
                                        <li>ราคา 450 บาท</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <hr style="border:2px solid pink;width:640px;margin-left: -1px;">
                        <div class="container">
                            <label for="topic"><i class="fas fa-map-marker"></i>&nbsp;ค้นหาหมอนวด</label>
                            <form method="POST">
                                <div class="form-group">
                                    <label for="">ช่วงเวลา</label>
                                    <input type="time" name="timesSrh" id="timesSrh">
                                    <label for="">ถึง</label>
                                    <input type="time" name="timeeSrh" id="timeeSrh">
                                    <button type="submit" name="srchTime" id="srchTime" class="btn btn-sm btn-primary"
                                        btn-sm btn-block>ค้นหาหมอนวด</button>
                                </div>
                            </form>
                            <table class="table" style="zoom:0.9">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th style="text-align:center;">สถานะหมอนวด</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
//Check เวลา ว่าถูกจองเวลานี้รึยัง
if (!empty($_POST['srchTime'])) {
    $timeS = $_POST['timesSrh'];
    $timeE = $_POST['timeeSrh'];
    $k = 1;
    if ($qry = $mysqli->prepare("SELECT bk.*, ur.user_name FROM hm_booking_details bk INNER JOIN hm_user ur ON bk.hm_user_id = ur.user_id WHERE bk_time >= ? AND bk_time_end <= ? GROUP BY ur.user_name")) {
        $qry->bind_param('ss', $timeS, $timeE);
        $qry->execute();
        $listChk = $qry->get_result();

        while ($chk = $listChk->fetch_object()) {?>
                                    <tr>
                                        <td scope="row"><?=$k++;?></td>
                                        <td><?=$chk->user_name?></td>
                                        <td style="color:red;text-align:center;"> ไม่ว่าง</td>
                                    </tr>
                                    <?php }} else {echo "Error";}}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <form method="post">
                    <div class="wrap-login100">
                        <span class="login100-form-title">
                            <i class="fas fa-bell"></i>
                            จองคิวนวด
                        </span>
                        <div class="wrap-input100 validate-input">
                            <label class="col-md-4" for="username">ชื่อ-สกุล</label>
                            <input autocomplete="off" class="form-control" type="text" name="username" id="username"
                                placeholder="ชื่อ-นามสกุล สำหรับการจอง" required>
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                        </div>
                        <div class="wrap-input100 validate-input">
                            <label class="col-md-4" for="tel">เบอร์โทร</label>
                            <input class="form-control" type="text" autocomplete="off" placeholder="เบอร์โทร" name="tel" id="tel" required>
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                        </div>
                        <div class="wrap-input100 validate-input">
                            <label class="col-md-4" for="email">ไลน์</label>
                            <input autocomplete="off" class="form-control" type="text" name="line" id="line"
                                placeholder="ไลน์ ID" required>
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                        </div>
                        <div class="wrap-input100 validate-input">
                            <label class="col-md-4" for="status">เลือกบริการ</label>
                            <select class="custom-select" id="bkid" name="bkid" required>
                                <option value="0">เลือกบริการ</option>
                                <?php while ($rs = $list->fetch_assoc()) {?>
                                <option value="<?=$rs['bk_id']?>"><?=$rs['bk_name'] . ' ' . $rs['bk_detail']?></option>
                                <?php }?>
                            </select>
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                        </div>
                        <div class="wrap-input100 validate-input">
                            <label class="col-md-8" for="status">เลือกรับบริการจากหมอนวด</label>
                            <select class="custom-select" name="empid" id="empid" required>
                                <option value="0">รายชื่อหมอนวด</option>
                                <?php while ($data = $r->fetch_assoc()) {?>
                                <option value="<?=$data['user_id']?>"><?=$data['user_name']?></option>
                                <?php }?>
                            </select>
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                        </div>
                        <div class="wrap-input100 form-group">
                            <label class="col-md-4" for="time">วันที่จอง</label>
                            <input type="text" autocomplete="off" name="bk_date" id="datepicker" data-date-format="DD MMMM YYYY"
                                class="form-control" required>
                        </div>
                        <div class="wrap-input100 validate-input form-group">
                            <label class="col-md-4" for="time">ช่วงเวลา</label>
                            <input class="form-control" type="time" name="timeStart" id="timeStart" required>
                            <label class="col-md-4" for="time">ถึง</label>
                            <input class="form-control" type="time" name="timeEnd" id="timeEnd" required>
                        </div>
                        <div class="container-login100-form-btn m-t-20">
                            <button class="login100-form-btn btn btn-primary" type="submit" name="save" id="btnBooking">
                                <i class="far fa-check-circle"></i>
                                ยืนยันการจอง
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    <div class="footer">
        <?php include "../components/footer.php";?>
    </div>
</body>

<!-- Script -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
</script>

<!-- for Date -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/th.js"></script> -->
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="../assets/Js/jqueryui_datepicker_thai_min.js"></script>

<!-- For Alert  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(document).ready(function() {
    $("#datepicker").datepicker_thai({
        dateFormat: 'dd/mm/yy',
        changeMonth: false,
        changeYear: true,
        numberOfMonths: 1,
        langTh: true,
        yearTh: true,
    });

    // $('#btnBooking').click(function(){
    //     var num= <?=$n?> ;
    //     if( num != 0 ){
    //         swal('ขออภัยคะ', 'ขออภัยคะ หมอนวดคนนี้ถูกจองคิว ช่วงเวลานี้แล้ว', 'warning');
    //     }
    // });
});
</script>

</html>