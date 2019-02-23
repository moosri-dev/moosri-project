<?php
if (!isset($_SESSION)) {
    session_start();
}
include "../config/connect-db.php";
if (isset($_POST['save'])) {
    $user = $_POST['username'];
    $pwd = $_POST['pass'];

    $sql = "";
    if ($result = $mysqli->query("select * from hm_user where user_user = '$user' and user_pass = '$pwd'")) {
        while ($a = $result->fetch_object()) {
            $_SESSION['status_id'] = $a->status_id;
            $_SESSION['user_id'] = $a->user_id;
            $_SESSION['user_name'] = $a->user_name;
            $_SESSION['user_tel'] = $a->user_tel;
            $_SESSION['user_email'] = $a->user_email;
            $_SESSION['user_line'] = $a->user_line;
            $_SESSION['user_address'] = $a->user_address;
            $_SESSION['user_img'] = $a->user_img;
        }
        if ($_SESSION['status_id'] == '1') { //admin
            header('location:../../src/pages/admin.php');
        } else { //member
            header('location:../../');
        }
    }
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
    <link rel="stylesheet" href="../assets/css/login-css.css">
</head>

<body>
    <div class="header">
        <?php include "../components/header.php";?>
    </div>
    <div class="content">
        <div class="row body_c">
            <div class="col-md-4 card_c card" style="width: 18rem;">
                <img class="card-img-top" src="../assets/images/thai-massage3.jpg" alt="Card image cap">
            </div>
            <div class="col-md-6">
                <form action="login.php" method="post" id="frmLogin">
                    <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
                        <form class="login100-form validate-form">
                            <span class="login100-form-title p-b-33">
                                เข้าสู่ระบบ
                            </span>
                            <div class="wrap-input100 validate-input">
                                <input autocomplete="false" class="form-control" type="text" name="username"
                                    placeholder="ชื่อผู้ใช้งาน">
                                <span class="focus-input100-1"></span>
                                <span class="focus-input100-2"></span>
                            </div>
                            <div class="wrap-input100 validate-input">
                                <input class="form-control" type="password" name="pass" placeholder="รหัสผ่าน">
                                <span class="focus-input100-1"></span>
                                <span class="focus-input100-2"></span>
                            </div>
                            <div class="container-login100-form-btn m-t-20">
                                <button class="login100-form-btn btn btn-primary" type="submit" name="save">
                                    เข้าสู่ระบบ
                                </button>
                            </div>
                            <div class="text-center p-t-45 p-b-4">
                                <span class="txt1">
                                    ลืมรหัสผ่าน
                                </span>
                                <a href="#" class="txt2 hov1">
                                    ชื่อผู้ใช้งาน / รหัสผ่าน?
                                </a>
                            </div>
                        </form>
                    </div>
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

</html>