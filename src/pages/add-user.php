<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="../assets/css/style.css">
    <?php 
        include('../components/global-variable.php');
        include('../assets/scripts/admin-script.php');
        echo '<title>'.$title.'</title>';

        if(isset($_POST['save'])){
            include('../config/connect-db.php');
            $username = $_POST['username'];
            $password = $_POST['password'];
            $name = $_POST['name'];
            $tel = $_POST['tel'];
            $email = $_POST['email'];
            $line = $_POST['line'];
            $address = $_POST['address'];
            $profile = $_POST['profile'];
            $status = $_POST['status'];

            $sql = "INSERT INTO 
            hm_user(user_user,user_pass,user_name,user_tel,user_email,user_line,user_address,user_img,status_id) 
            VALUES(?,?,?,?,?,?,?,?,?)";

            /* create a prepared statement */
            if($stmt = $mysqli->prepare($sql)){

                /* bind parameters for markers */
                $stmt->bind_param('ssssssssi',$username,$password,$name,$tel,$email,$line,$address,$profile,$status);
                
                /* execute query */
                $stmt->execute();

                /* close statement */
                $stmt->close();
                
                echo "Insert data success!";
                header('location: admin-management.php');
            }else{
                echo "Error:".$sql."<br>".$mysqli->error;
                header('refresh:2;');
            }
            $mysqli->close();

            exit(0);
        }
    ?>

<!-- DataTables JavaScript -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
     <script type="text/javascript">
        function validate(){
                let password =document.getElementById("password").value;
                let confirmPassword =document.getElementById("confirmPassword").value;
                let saveBtn = document.getElementById("save");
                if(confirmPassword != ""){
                    if(password != confirmPassword) {
                        document.getElementById("wrong").style.display = "block";
                        saveBtn.disabled = true;
                    }else{
                        document.getElementById("wrong").style.display = "none";
                        saveBtn.disabled = false;
                    }
                }
            };
    </script>

</head>

<body>
    <div id="wrapper">
        <?php include('../components/menu.php'); ?>
        <div id="page-wrapper">

        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">จัดการข้อมูลผู้ใช้งาน</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
            <div class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            เพิ่มข้อมูลผู้ใช้งาน
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form method="post">
                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="inputUsername">ชื่อผู้ใช้งาน<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="username" class="form-control" placeholder='ชื่อผู้ใช้งาน' maxlength='50' required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="inputPassword">รหัสผ่าน<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="password" id="password" name="password" class="form-control" placeholder='รหัสผ่าน' maxlength='50' onkeyup="validate();" required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="inputConfirmPassword">ยืนยันรหัสผ่าน<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div id="wrong" style="color:red;font-weight:bold;" hidden>ยืนยันรหัสผ่านไม่ถูกต้อง!</div>
                                        <input type="password" id="confirmPassword" class="form-control" placeholder='ยืนยันรหัสผ่าน' maxlength='50' onkeyup="validate();" required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="name">ชื่อ-นามสกุล<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="name" class="form-control" placeholder='ชื่อ-นามสกุล' maxlength='50' required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="tel">เบอร์โทร<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="tel" class="form-control" placeholder='เบอร์โทร' maxlength='10' required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="email">อีเมล์<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="email" class="form-control" placeholder='อีเมล์' maxlength='50' pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?" required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="email">ไลน์ไอดี<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="line" class="form-control" placeholder='ไลน์ไอดี' maxlength='50' required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="address">ที่อยู่ :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <textarea name="address"rows="3" class="form-control" placeholder='ที่อยู่'></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="profile">รูปโปรไฟล์ :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="input-file-container">  
                                            <input class="input-file" name="profile" id="my-file" type="file">
                                            <label tabindex="0" for="my-file" class="input-file-trigger">เลือกไฟล์</label>
                                        </div>
                                        <p class="file-return"></p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="profile">สถานะ<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="status" id="" class="form-control" required>
                                            <option value="">เลือกสถานผู้ใช้งาน</option>
                                            <option value="1">ผู้ดูแลระบบ</option>
                                            <option value="2">หมอนวด</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-lg btn-block btn-primary" id="save" name="save">บันทึกข้อมูล</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <script type="text/javascript">
        document.querySelector("html").classList.add('js');
        var fileInput  = document.querySelector( ".input-file" ),  
            button     = document.querySelector( ".input-file-trigger" ),
            the_return = document.querySelector(".file-return");
            
        button.addEventListener( "keydown", function( event ) {  
            if ( event.keyCode == 13 || event.keyCode == 32 ) {  
                fileInput.focus();  
            }  
        });
        button.addEventListener( "click", function( event ) {
        fileInput.focus();
        return false;
        });  
        fileInput.addEventListener( "change", function( event ) {  
            the_return.innerHTML = this.value;  
        });  
    </script>
</body>
</html>
