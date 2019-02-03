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

        if(isset($_POST['save'])){
            include('../config/connect-db.php');
            $username = $_POST['username'];
            $password = $_POST['password'];
            $name = $_POST['name'];
            $tel = $_POST['tel'];
            $email = $_POST['email'];
            $line = $_POST['line'];
            $address = $_POST['address'];
            $status = $_POST['status'];

            $sql = "INSERT INTO 
            hm_user(username,password,name,tel,email,line,address,status_id) 
            VALUES('$username','$password','$name','$tel','$email','$line','$address',$status)";

            if($mysqli->query($sql)){
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
  <!-- <script src="../assets/libs/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../assets/libs/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../assets/libs/vendor/datatables-responsive/dataTables.responsive.js"></script> -->
    
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
     <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                responsive: true
            });
        });
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
                                    <div class="col-md-3 text-right">
                                        <label for="inputUsername">ชื่อผู้ใช้งาน:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="username" class="form-control" placeholder='ชื่อผู้ใช้งาน' maxlength='50'/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3 text-right">
                                        <label for="inputPassword">รหัสผ่าน:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="password" name="password" class="form-control" placeholder='รหัสผ่าน' maxlength='50'/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3 text-right">
                                        <label for="comfirmPassword">ยืนยันรหัสผ่าน:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" placeholder='ยืนยันรหัสผ่าน' maxlength='50'/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3 text-right">
                                        <label for="name">ชื่อ-นามสกุล:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="name" class="form-control" placeholder='ชื่อ-นามสกุล' maxlength='50'/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3 text-right">
                                        <label for="tel">เบอร์โทร:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="tel" class="form-control" placeholder='เบอร์โทร' maxlength='10'/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3 text-right">
                                        <label for="email">อีเมล์:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="email" class="form-control" placeholder='อีเมล์' maxlength='50'/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3 text-right">
                                        <label for="email">ไลน์ไอดี:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="line" class="form-control" placeholder='ไลน์ไอดี' maxlength='50'/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3 text-right">
                                        <label for="address">ที่อยู่:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea name="address"rows="3" class="form-control" placeholder='ที่อยู่'></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3 text-right">
                                        <label for="profile">รูปโปรไฟล์:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <button class="btn btn-block btn-info">เลือกรูปโปรไฟล์</button>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3 text-right">
                                        <label for="profile">สถานะ:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="status" id="" class="form-control">
                                            <option value="">เลือกสถานผู้ใช้งาน</option>
                                            <option value="1">ผู้ดูแลระบบ</option>
                                            <option value="2">หมอนวด</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-lg btn-block btn-primary" name="save">บันทึกข้อมูล</button>
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
</body>
</html>
