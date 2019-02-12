<?php
if (!isset($_SESSION)) {session_start();}
include "../config/connect-db.php";

if (isset($_POST['save'])) {
    $username = $_POST['username'];
    $pwdOld = $_POST['pwdOld'];
    $pwdNew = $_POST['pwdNew'];
    $pwdReNew = $_POST['pwdReNew'];

    //Select
    if ($stmtSel = $mysqli->prepare("SELECT * FROM hm_user WHERE user_id = ?")) {
        $stmtSel->bind_param('i', $_SESSION['user_id']);
        $stmtSel->execute();
        $result = $stmtSel->get_result();
        if ($result->num_rows === 0) {
            echo "<script type='text/javascript'>alert('have\'t User') </script>";
        } else {
            $rs=$result->fetch_assoc();
            //Update
            if($rs['user_pass'] != $pwdOld){
                echo "<script type='text/javascript'>alert('Password Not Found in Register !!') </script>";
            }else {
                if($pwdNew != $pwdReNew){
                    echo "<script type='text/javascript'>alert('Password Not Match!!') </script>";
                }else {
                    if ($stmt = $mysqli->prepare("UPDATE hm_user SET user_user=?,user_pass=? WHERE user_id = ?")) {
                        $stmt->bind_param('ssi',$username,$pwdNew,$_SESSION['user_id']);
                        $stmt->execute();
                    }
                }
            }   
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
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>

<body>
    <div class="header">
        <?php include "../components/header.php";?>
    </div>
    <div class="content">
        <div class="row body_c">
            <div class="col-md-4 card_c card" style="width: 18rem;height:26rem;">
                <div class="row">
                    <div class="imame-user" style="margin:10px 110px 10px 10px;">
                    <img class="img-profile img-circle img-responsive center-block"
                                src="<?=$_SESSION['user_img']?>" alt="profile" width="200" height="200">
                        <div class="form-group">
                            <!-- <label for="exampleFormControlFile1">แก้ไขรูปภาพ</label> -->
                            <!-- <input type="file" class="form-control-file" id="exampleFormControlFile1"> -->
                        </div>
                    </div>
                    <div class="user-info col-md-6">
                        <label class="label_c" style="margin:10px 0px 0px -50px;font-size:26px;">ข้อมูลส่วนตัว</label>
                        <div class="row" style="margin:10px 0px -15px -50px;font-size:18px;">
                            <label class="label_c">ชื่อ-สกุล : <?=$_SESSION['user_name'];?></label>
                        </div>
                        <div class="row" style="margin:10px 0px -15px -50px;font-size:18px;">
                            <label class="label_c">เบอร์โทร : <?=$_SESSION['user_tel'];?></label>
                        </div>
                        <div class="row" style="margin:10px 0px -15px -50px;font-size:18px;">
                            <label class="label_c">อีเมล์ : <?=$_SESSION['user_email'];?></label>
                        </div>
                        <div class="row" style="margin:10px 0px -15px -50px;font-size:18px;">
                            <label class="label_c">ไลน์ : <?=$_SESSION['user_line'];?></label>
                        </div>
                        <div class="row" style="margin:10px 0px -15px -50px;font-size:18px;">
                            <label class="label_c">สถานะ :
                                <?=($_SESSION['status_id'] == '1' ? 'ผู้ดูแลระบบ' : 'หมอนวด');?></label>
                        </div>
                    </div>
                    <div>
                        <hr style="border:2px solid pink;width:640px;margin-left: -1px;">
                        <ul class="menuList">
                            <li>
                                <a href="profile.php"> &nbsp;&nbsp;> แก้ไขข้อมูลส่วนตัว</a>
                            </li>
                            <li>
                                <a href="edit_profile_login.php">&nbsp;&nbsp;> แก้ไขรหัสผ่าน
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <form action="#" method="post" id="frmLogin">
                    <div class="wrap-login100">
                        <form class="login100-form validate-form">
                            <span class="login100-form-title">
                            <i class="fas fa-user-edit"></i>    
                            แก้ไขข้อมูลล็อกอิน
                            </span>
                            <div class="wrap-input100 validate-input">
                                <label class="col-md-6" for="username">ชื่อผู้ใช้งาน
                                    <span style="color:red;padding-left:2%;">*</span>
                                </label>
                                <input autocomplete="false" class="form-control" type="text" name="username"
                                    placeholder="ชื่อผู้ใช้งาน">
                                <span class="focus-input100-1"></span>
                                <span class="focus-input100-2"></span>
                            </div>
                            <div class="wrap-input100 validate-input">
                                <label class="col-md-6" for="tel">รหัสผ่านเดิม
                                <span style="color:red;padding-left:2%;">*</span>
                                </label>
                                <input class="form-control" type="password" name="pwdOld" placeholder="รหัสผ่านเดิม">
                                <span class="focus-input100-1"></span>
                                <span class="focus-input100-2"></span>
                            </div>
                            <div class="wrap-input100 validate-input">
                                <label class="col-md-6" for="email">รหัสผ่านใหม่
                                <span style="color:red;padding-left:2%;">*</span>
                                </label>
                                <input autocomplete="false" class="form-control" type="password" name="pwdNew"
                                    placeholder="รหัสผ่านใหม่">
                                <span class="focus-input100-1"></span>
                                <span class="focus-input100-2"></span>
                            </div>
                            <div class="wrap-input100 validate-input">
                                <label class="col-md-6" for="email">ยืนยันรหัสผ่านใหม่
                                <span style="color:red;padding-left:2%;">*</span>
                                </label>
                                <input autocomplete="false" class="form-control" type="password" name="pwdReNew"
                                    placeholder="ยืนยันรหัสผ่านใหม่">
                                <span class="focus-input100-1"></span>
                                <span class="focus-input100-2"></span>
                            </div>
                            <div class="container-login100-form-btn m-t-20">
                                <button class="login100-form-btn btn btn-primary" type="submit" name="save">
                                <i class="fas fa-user-edit"></i>    
                                แก้ไขข้อมูล
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