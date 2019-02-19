<?php
if (!isset($_SESSION)) {session_start();}
include "../config/connect-db.php";

//select user all
$stmt = $mysqli->prepare("SELECT * FROM hm_user");
$stmt->execute();
$r = $stmt->get_result();
$countAll = $r->num_rows;

//select massage_list
$ms = $mysqli->prepare("SELECT * FROM hm_booking");
$ms->execute();
$list = $ms->get_result();

// CREATE TABLE `moosi-massage`.`hm_booking_details` ( `bk_id` INT NOT NULL AUTO_INCREMENT , `bk_fullname` VARCHAR(50) NOT NULL , `bk_tel` VARCHAR(12) NOT NULL , `bk_line` VARCHAR(15) NOT NULL , `book_time` TIME(6) NOT NULL , `hm_user_id` INT(2) NOT NULL , `bk_id_fk` INT(2) NOT NULL , PRIMARY KEY (`bk_id`)) ENGINE = InnoDB;
//add data booking
if (isset($_POST['save'])) {
    $name = $_POST['username'];
    $tel = $_POST['tel'];
    $line = $_POST['line'];
    $bkid = $_POST['bkid'];
    $empid = $_POST['empid'];
    $timeS = $_POST['timeStart'];

    $ms2 = $mysqli->prepare("SELECT bk_time FROM hm_booking WHERE bk_id = ?");
    $ms2->bind_param("i", $bkid);
    $ms2->execute();
    $list2 = $ms2->get_result();
    $useTime;
    while ($row = $list2->fetch_assoc()) {
        $useTime = $row['bk_time'];
    }

    $calTime = substr($timeS,0,2);
    $x = ($calTime+$useTime);
    $timeEnd = strtotime($x);
    
    // echo "timeS : ".substr($timeS,0,2);
    echo "useTime : ".$timeEnd;
    // echo "timeS + useTime ".($calTime+$useTime);

    // $sql = "INSERT INTO hm_booking_details(bk_fullname, bk_tel, bk_line, bk_id_fk, hm_user_id, bk_time,bk_time_end) VALUES(?,?,?,?,?,?,?)";
    // if($q=$mysqli->prepare($sql)){
    //     $q->bind_param('sssiiss',$name,$tel,$line,$bkid,$empid,$timeS,$timeEnd);
    //     $q->execute();
    // }else{
    //     echo "Error:".$sql."<br>".$mysqli->error;
    // }
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
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/booking.css">
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
                            <form method="get">
                                <div class="form-group">
                                    <label for="">ช่วงเวลา</label>
                                    <input type="time" name="time" id="time" min="9:00" max="18:00">
                                    <label for="">ถึง</label>
                                    <input type="time" name="time" id="time" min="9:00" max="18:00">
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
                                    <tr>
                                        <td scope="row">1</td>
                                        <td>หมอนวด ขยัน</td>
                                        <td style="color:green;text-align:center;"> ว่าง</td>
                                    </tr>
                                    <tr>
                                        <td scope="row">2</td>
                                        <td>sora aoi</td>
                                        <td style="color:red;text-align:center;">ไม่ว่าง</td>
                                    </tr>
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
                            <input autocomplete="false" class="form-control" type="text" name="username"
                                placeholder="ชื่อ-นามสกุล สำหรับการจอง">
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                        </div>
                        <div class="wrap-input100 validate-input">
                            <label class="col-md-4" for="tel">เบอร์โทร</label>
                            <input class="form-control" type="text" placeholder="เบอร์โทร" name="tel">
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                        </div>
                        <div class="wrap-input100 validate-input">
                            <label class="col-md-4" for="email">ไลน์</label>
                            <input autocomplete="false" class="form-control" type="text" name="line"
                                placeholder="ไลน์ ID">
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                        </div>
                        <div class="wrap-input100 validate-input">
                            <label class="col-md-4" for="status">เลือกบริการ</label>
                            <select class="custom-select" id="bkid" name="bkid">
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
                            <!-- <small id="helpId" class="form-text text-muted">(ระบบแสดงเฉพาะข้อมูลหมอนวดที่ ว่าง)</small> -->
                            <select class="custom-select" name="empid" id="empid">
                                <option value="0">รายชื่อหมอนวด</option>
                                <?php while ($data = $r->fetch_assoc()) {?>
                                <option value="<?=$data['user_id']?>"><?=$data['user_name']?></option>
                                <?php }?>
                            </select>
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                        </div>
                        <div class="wrap-input100 validate-input form-group">
                            <label class="col-md-4" for="time">ช่วงเวลา</label>
                            <input class="form-control" type="time" name="timeStart" id="timeStart" >
                            <!-- <label for="">ถึง</label>
                            <input type="time" name="timeEnd" id="timeEnd" min="9:00" max="18:00"> -->
                        </div>
                        <div class="container-login100-form-btn m-t-20">
                            <button class="login100-form-btn btn btn-primary" type="submit" name="save">
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
<script src="../assets/Js/header.js"></script>
<script src="../assets/Js/login.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
</script>
<!-- <script language="javascript"> window.location.href = "src/pages/index.php"</script> -->

<script type="text/javascript">
var timepicker = new TimePicker('timeStart', {
    lang: 'en',
    theme: 'dark'
});
timepicker.on('change', function(evt) {
    var value = (evt.hour || '00') + ':' + (evt.minute || '00');
    evt.element.value = value;
});
</script>

</html>