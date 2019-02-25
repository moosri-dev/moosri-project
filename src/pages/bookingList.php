<?php
if (!isset($_SESSION)) {session_start();}
include "../config/connect-db.php";

// if (isset($_POST['search'])) {
//select status = 1
$stmt = $mysqli->prepare("SELECT bk.*,mbk.bk_name,MOD(HOUR(TIMEDIFF(bk.bk_time, CURRENT_TIME())),60) as hour,MOD(MINUTE(TIMEDIFF(bk.bk_time, CURRENT_TIME())),60) as timer FROM hm_booking_details bk INNER JOIN hm_booking mbk ON bk.bk_id_fk = mbk.bk_id WHERE CURRENT_TIME() < bk.bk_time AND bk.status = 1 ORDER BY bk.bk_time");
$stmt->execute();
$rs = $stmt->get_result();
$num = $rs->num_rows;
//select status = 2
$stm2 = $mysqli->prepare("SELECT bk.*,mbk.bk_name,MOD(HOUR(TIMEDIFF(bk.bk_time, CURRENT_TIME())),60) as hour,MOD(MINUTE(TIMEDIFF(bk.bk_time, CURRENT_TIME())),60) as timer FROM hm_booking_details bk INNER JOIN hm_booking mbk ON bk.bk_id_fk = mbk.bk_id WHERE CURRENT_TIME() < bk.bk_time AND bk.status = 2 ORDER BY bk.bk_time");
$stm2->execute();
$rs2 = $stm2->get_result();

if (!empty($_GET['searchBtn'])) {
    $search = "%{$_GET['srcTxt']}%";
    $sql2 = "SELECT * FROM hm_booking_details WHERE user_name LIKE ?";
    $stmt2 = $mysqli->prepare($sql2);
    $stmt2->bind_param('s', $search);
    $stmt2->execute();
    $rs = $stmt2->get_result();
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
    <link rel="stylesheet" href="../assets/css/search.css">
</head>

<body>
    <div class="header">
        <?php include "../components/header.php";?>
    </div>
    <div class="content" style="margin:0% 0% 15% 10%;width:80%;">
        <div class="row body_c">
            <div class="col-md-12 card_search">
                <form method="get">
                    <div class="row" style="margin:5% 0% 2% 0%;">
                        <div class="col-md-12 form-group">
                            <h4 for="search">
                                <i class="fas fa-glasses"></i>&nbsp;&nbsp;รายการนวดทั้งหมด</h4>
                            <input autocomplete="off" type="text" class="form-control form-control-md" name="srcTxt"
                                id="srcTxt" placeholder="นางสางขยันนวด ทุกวัน" required>
                            <small id="helpId" class="form-text text-muted">ค้นหาหมอนวดจาก ชื่อ,นามสกุล ลูกค้า</small>
                            <button type="submit" name="searchBtn" id="searchBtn" class="btn btn-primary" btn-md
                                btn-block>
                                <i class="fas fa-glasses"></i>
                                ค้นหา</button>
                        </div>
                    </div>
                </form>
                <table class="table table-bordered">
                    <thead class="table-danger">
                        <tr class="text-center">
                            <th scope="col">ลำดับ</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>จองบริการ</th>
                            <th>เบอร์โทร</th>
                            <th>ไลน์ ไอดี</th>
                            <th>วันเดือนปี</th>
                            <th>เวลาเริ่ม</th>
                            <th>เวลาสิ้นสุด</th>
                            <th>เวลาที่เหลือเข้ารับบริการ</th>
                            <!-- <th>ดำเนินการ</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;while ($row = $rs->fetch_assoc()) {?>
                        <tr>
                            <td class="text-center"><?=$i;?></td>
                            <td scope="row"><?=$row['bk_fullname']?></td>
                            <td><?=$row['bk_name']?></td>
                            <td class="text-center"><?=$row['bk_tel']?></td>
                            <td class="text-center"><?=$row['bk_line']?></td>
                            <td class="text-center"><?=$row['bk_date']?></td>
                            <td class="text-center"><?=substr($row['bk_time'], 0, 5)?></td>
                            <td class="text-center"><?=substr($row['bk_time_end'], 0, 5)?></td>
                            <?php if ($row['hour'] == 0 && $row['timer'] < 30) {?>
                            <td class="text-center" style="color:red">
                                <?=$row['hour'] . ' ชั่วโมง ' . $row['timer'] . ' นาที'?></td>
                            <?php } else {?>
                            <td class="text-center"><?=$row['hour'] . ' ชั่วโมง ' . $row['timer'] . ' นาที'?></td>
                            <?php }?>
                            <!-- <td class="text-center">
                                <a href="booking_edit.php?eid=<?=$row['bk_id']?>"><i
                                        class="far fa-edit"></i></a>&nbsp;&nbsp;
                                <a href="delete-booking-details.php?id=<?=$row['bk_id']?>"><i
                                        class="far fa-bell-slash"></i></a>
                            </td> -->
                        </tr>
                        <?php $i++;}?>
                        <tr class="text-right">
                        <?php if($num != 0){?>
                            <td colspan="10">
                                <button type="button" id="btnNotify" class="btn btn-primary">ส่งข้อความแจ้งเตือน</button>
                            </td>
                        <?php }else{ ?>
                            <td colspan="10">
                                <button disabled type="button" id="btnNotify" class="btn btn-primary">ส่งข้อความแจ้งเตือน</button>
                            </td>
                        <?php } ?>
                        </tr>
                    </tbody>
                </table>
            </div><!-- close table 1 -->
            <div class="col-md-12 card_search">
                <form action="#" method="post" name="actButton">
                    <h4 for="search"><i class="fas fa-sms"></i>&nbsp;&nbsp;รายการนวดที่ส่งข้อความบริการแล้วทั้งหมด</h4>
                    <table class="table table-bordered">
                        <thead class="table-danger">
                            <tr class="text-center">
                                <th scope="col">ลำดับ</th>
                                <th>ชื่อ-นามสกุล</th>
                                <th>จองบริการ</th>
                                <th>เบอร์โทร</th>
                                <th>ไลน์ ไอดี</th>
                                <th>วันเดือนปี</th>
                                <th>เวลาเริ่ม</th>
                                <th>เวลาสิ้นสุด</th>
                                <th>เวลาที่เหลือเข้ารับบริการ</th>
                                <!-- <th>ดำเนินการ</th> -->
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;while ($row2 = $rs2->fetch_assoc()) {?>
                        <tr>
                            <td class="text-center"><?=$i;?></td>
                            <td scope="row"><?=$row2['bk_fullname']?></td>
                            <td><?=$row2['bk_name']?></td>
                            <td class="text-center"><?=$row2['bk_tel']?></td>
                            <td class="text-center"><?=$row2['bk_line']?></td>
                            <td class="text-center"><?=$row2['bk_date']?></td>
                            <td class="text-center"><?=substr($row2['bk_time'], 0, 5)?></td>
                            <td class="text-center"><?=substr($row2['bk_time_end'], 0, 5)?></td>
                            <?php if ($row2['hour'] == 0 && $row2['timer'] < 30) {?>
                            <td class="text-center" style="color:red">
                                <?=$row2['hour'] . ' ชั่วโมง ' . $row2['timer'] . ' นาที'?></td>
                            <?php } else {?>
                            <td class="text-center"><?=$row2['hour'] . ' ชั่วโมง ' . $row2['timer'] . ' นาที'?></td>
                            <?php }?>
                            <!-- <td class="text-center">
                                <a href="booking_edit.php?eid=<?=$row2['bk_id']?>"><i
                                        class="far fa-edit"></i></a>&nbsp;&nbsp;
                                <a href="delete-booking-details.php?id=<?=$row2['bk_id']?>"><i
                                        class="far fa-bell-slash"></i></a>
                            </td> -->
                        </tr>
                        <?php $i++;}?>
                        </tbody>
                    </table>
                </form>
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
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert"></script> -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(document).ready(function () {
    $('#btnNotify').on('click',function(){
        $.ajax({
            type: "get",
            url: "../config/auto_notify.php",
            success: function (response) {
                swal({
                    text:'ส่งข้อความแจ้งเตือนเรียบร้อยแล้วค่ะ',
                    icon: "success",
                })
            },
            error:function(err){
                swal({
                    text:'ไม่พบข้อมูลที่ต้องแจ้งเตือน',
                    icon: "warning",
                })
            }
        });
    });
});
</script>

</html>