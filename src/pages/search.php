<?php
if (!isset($_SESSION)) {session_start();}
include "../config/connect-db.php";

// if (isset($_POST['search'])) {

$stmt = $mysqli->prepare("SELECT * FROM hm_user");
$stmt->execute();
$rs = $stmt->get_result();

if (isset($_GET['searchBtn'])) {
    $search = "%{$_GET['srcTxt']}%";
    $sql2 = "SELECT * FROM hm_user WHERE user_name LIKE ?";
    $stmt2 = $mysqli->prepare($sql2);
    $stmt2->bind_param('s', $search);
    $stmt2->execute();
    $rs = $stmt2->get_result();//->fetch_all(MYSQLI_ASSOC);
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
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>

<body>
    <div class="header">
        <?php include "../components/header.php";?>
    </div>
    <div class="content" style="margin:0% 0% 15% 10%;width:80%;">
        <div class="row body_c">
            <div class="col-md-12">
                <form method="get">
                    <div class="row" style="margin:10% 0% 2% 0%;">
                        <div class="col-md-12 form-group">
                            <label for="search">ค้นหาหมอนวด</label>
                            <input autocomplete="off" type="text" class="form-control form-control-md" name="srcTxt" id="srcTxt" placeholder="นางสางขยันนวด ทุกวัน">
                            <small id="helpId" class="form-text text-muted">ค้นหาหมอนวดจาก ชื่อ,นามสกุล</small>
                            <button type="submit" name="searchBtn" id="searchBtn" class="btn btn-primary" btn-md
                                btn-block>
                                <i class="fas fa-search"></i>
                                ค้นหาหมอนวด</button>
                        </div>
                    </div>
                </form>
                <table class="table table-bordered">
                    <thead class="table-danger">
                        <tr class="text-center">
                            <th scope="col">ลำดับ</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>เบอร์โทร</th>
                            <th>อีเมล์</th>
                            <th>ไลน์ ไอดี</th>
                            <th>ที่อยู่</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;while ($row = $rs->fetch_assoc()) {?>
                        <tr>
                            <td><?=$i;?></td>
                            <td scope="row"><?=$row['user_name']?></td>
                            <td><?=$row['user_tel']?></td>
                            <td><?=$row['user_email']?></td>
                            <td><?=$row['user_line']?></td>
                            <td><?=$row['user_address']?></td>
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