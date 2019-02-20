<?php
if (!isset($_SESSION)) {session_start();}
include "../config/connect-db.php";

// if (isset($_POST['search'])) {

$stmt = $mysqli->prepare("SELECT * FROM hm_booking_details");
$stmt->execute();
$rs = $stmt->get_result();

if (isset($_GET['searchBtn'])) {
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
                            <input autocomplete="off" type="text" class="form-control form-control-md" name="srcTxt" id="srcTxt" placeholder="นางสางขยันนวด ทุกวัน">
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
                            <th>เบอร์โทร</th>
                            <th>ไลน์ ไอดี</th>
                            <th>เวลาเริ่ม</th>
                            <th>เวลาสิ้นสุด</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;while ($row = $rs->fetch_assoc()) {?>
                        <tr>
                            <td class="text-center"><?=$i;?></td>
                            <td scope="row"><?=$row['bk_fullname']?></td>
                            <td><?=$row['bk_tel']?></td>
                            <td class="text-center"><?=$row['bk_line']?></td>
                            <td class="text-center"><?=substr($row['bk_time'],0,5)?></td>
                            <td class="text-center"><?=substr($row['bk_time_end'],0,5)?></td>
                        </tr>
                        <?php $i++;}?>
                    </tbody>
                </table>
                <!-- </div> -->
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

</html>