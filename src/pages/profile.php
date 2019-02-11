<?php
if (!isset($_SESSION)) {session_start();}
include "../config/connect-db.php";

// Check if image file is a actual image or fake image
$file_save = '';
if (isset($_POST['save'])) {
    // /opt/lampp/htdocs/moosri-project/src/assets/uploads
    $file_name = $_FILES['fileToUpload']['name'];
    $temp_name = $_FILES['fileToUpload']['tmp_name'];
    $file_err = $_FILES['fileToUpload']['error'];
    $file_size = $_FILES['fileToUpload']['size'];
    $location = '../uploads';
    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));
    $file_allow = array('jpg', 'jpeg', 'png');
    if (in_array($file_ext, $file_allow)) {
        if ($file_err === 0) {
            if($file_size <= 2097152){
            $file_name_new = uniqid('', true) . '.' . $file_ext;
            $file_destination = $location . '/' . $file_name_new;
            move_uploaded_file($temp_name, $file_destination);
            }
        }
    }

    $username = $_POST['username'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $line = $_POST['lineID'];
    $address = $_POST['address'];
    $status = $_POST['statusid'] = 2;
    $userId = $_SESSION['user_id'];

    $sql = "UPDATE hm_user SET user_name=?,user_tel=?,user_email=?,user_line=?,user_address=?,user_img=?,status_id=? WHERE user_id = ?";

    /* create a prepared statement */
    if ($stmt = $mysqli->prepare("UPDATE hm_user SET user_name=?,user_tel=?,user_email=?,user_line=?,user_address=?,user_img=?,status_id=? WHERE user_id = ?")) {

        /* bind parameters for markers */
        $stmt->bind_param('ssssssii', $username, $tel, $email, $line, $address, $file_destination, $status, $userId);

        /* execute query */
        $stmt->execute();
        $stmt->fetch();
        $result = $stmt->get_result();

        /* close statement */
        $stmt->close();
        // header('location: profile.php');
    } else {
        echo "Error:" . $sql . "<br>" . $mysqli->error;
        // header('refresh:2;');
    }
    

    $stmt2 = $mysqli->prepare("SELECT * FROM hm_user WHERE user_id = ?");
    $stmt2->bind_param("i", $userId);
    $stmt2->execute();
    $rs = $stmt2->get_result();
    if ($rs->num_rows === 0) {
        exit('No rows : '.$userId);
    }else{
        while ($row = $rs->fetch_assoc()) {
            $_SESSION['user_img'] = $row['user_img'];
            $_SESSION['status_id']=$row['status_id'];
            $_SESSION['user_id']=$row['user_id'];
            $_SESSION['user_name']=$row['user_name'];
            $_SESSION['user_tel']=$row['user_tel'];
            $_SESSION['user_email']=$row['user_email'];
            $_SESSION['user_line']=$row['user_line'];
            $_SESSION['user_address']=$row['user_address'];
    
        }
    }
    $mysqli->close();
    // exit(0);
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
    <form action="#" method="post" enctype="multipart/form-data">
        <div class="content">
            <div class="row body_c">
                <div class="col-md-4 card_c card" style="width: 18rem;">
                    <div class="row">
                        <div class="imame-user" style="margin:10px 10px 10px 10px;">
                            <img class="img-profile img-circle img-responsive center-block"
                                src="<?=$_SESSION['user_img']?>" alt="profile" width="200" height="200">
                                <!-- src="https://bootdey.com/img/Content/avatar/avatar6.png" alt=""> -->
                            <div class="form-group">
                                <label for="exampleFormControlFile1">แก้ไขรูปภาพ</label>
                                <input type="file" class="form-control-file" id="fileToUpload" name="fileToUpload">
                            </div>
                        </div>
                        <div class="user-info col-md-6">
                            <label class="label_c"
                                style="margin:10px 0px 0px -50px;font-size:26px;">ข้อมูลส่วนตัว</label>
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
                    <div class="wrap-login100">
                        <span class="login100-form-title">
                            แก้ไขข้อมูลส่วนตัว
                        </span>
                        <div class="wrap-input100 validate-input">
                            <label class="col-md-4" for="username">ชื่อ-สกุล</label>
                            <input autocomplete="false" class="form-control" type="text" name="username"
                                placeholder="ชื่อผู้ใช้งาน" value="<?=$_SESSION['user_name'];?>">
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                        </div>
                        <div class="wrap-input100 validate-input">
                            <label class="col-md-4" for="tel">เบอร์โทร</label>
                            <input class="form-control" type="text" name="tel" value="<?=$_SESSION['user_tel'];?>"
                                placeholder="เบอร์โทร">
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                        </div>
                        <div class="wrap-input100 validate-input">
                            <label class="col-md-4" for="email">อีเมล์</label>
                            <input autocomplete="false" class="form-control" type="text" name="email"
                                value="<?=$_SESSION['user_email'];?>" placeholder="อีเมล์">
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                        </div>
                        <div class="wrap-input100 validate-input">
                            <label class="col-md-4" for="line">ไลน์</label>
                            <input class="form-control" type="text" name="lineID" value="<?=$_SESSION['user_line'];?>"
                                placeholder="ไลน์">
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                        </div>
                        <div class="wrap-input100">
                            <label class="col-md-4" for="line">ที่อยู่</label>
                            <textarea class="form-control" name="address" rows="3">
                                <?=trim($_SESSION['user_address']);?>
                                </textarea>
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                        </div>
                        <div class="wrap-input100 validate-input">
                            <label class="col-md-4" for="status">สถานะ</label>
                            <select class="custom-select" name="statusid" id="statusid" disabled>
                                <option value="2"><?=($_SESSION['status_id'] == '1' ? 'ผู้ดูแลระบบ' : 'หมอนวด');?></option>
                            </select>
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                        </div>
                        <div class="container-login100-form-btn m-t-20">
                            <button class="login100-form-btn btn btn-primary" type="submit" name="save">
                                แก้ไขข้อมูลส่วนตัว
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