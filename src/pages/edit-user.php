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
       
        include('../config/connect-db.php');
        $sql= 'SELECT u.id, u.username,u.password,u.name,u.tel,u.email,u.line,u.address,u.image,u.status_id
            FROM hm_user u
            WHERE u.id =?';
        if($stmt = $mysqli->prepare($sql)){
            $userId = $_GET['id'];
            $stmt->bind_param('i',$userId);
            $stmt->execute();
            $result  = $stmt->get_result();
            while($rs=$result->fetch_object()){
    ?>

<!-- DataTables JavaScript -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    
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
                            แก้ไขข้อมูลผู้ใช้งาน
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form method="post" action="pages/update-user.php">
                                <div class="form-group row">
                                    <input type="text" name="userId"  value='<?php echo $rs->id ?>' hidden/>
                                    <div class="col-md-4 text-right">
                                        <label for="inputUsername">ชื่อผู้ใช้งาน<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="username" class="form-control" placeholder='ชื่อผู้ใช้งาน' maxlength='50' value='<?php echo $rs->username ?>' required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="inputPassword">รหัสผ่าน<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="password" name="password" class="form-control" placeholder='รหัสผ่าน' maxlength='50' value='<?php echo $rs->password ?>' required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="comfirmPassword">ยืนยันรหัสผ่าน<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="password" class="form-control" placeholder='ยืนยันรหัสผ่าน' maxlength='50' value='<?php echo $rs->password ?>' required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="name">ชื่อ-นามสกุล<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="name" class="form-control" placeholder='ชื่อ-นามสกุล' maxlength='50' value='<?php echo $rs->name ?>' required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="tel">เบอร์โทร<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="tel" class="form-control" placeholder='เบอร์โทร' maxlength='10' value='<?php echo $rs->tel ?>' required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="email">อีเมล์<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="email" class="form-control" placeholder='อีเมล์' maxlength='50' value='<?php echo $rs->email ?>' required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="email">ไลน์ไอดี<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="line" class="form-control" placeholder='ไลน์ไอดี' maxlength='50' value='<?php echo $rs->line ?>' required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="address">ที่อยู่ :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <textarea name="address"rows="3" class="form-control" placeholder='ที่อยู่'><?php echo $rs->address ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="profile">รูปโปรไฟล์ :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="input-file-container">  
                                            <input class="input-file" name="profile" id="my-file" type="file" value="<?php echo $rs->image ?>">
                                            <label tabindex="0" for="my-file" class="input-file-trigger">เลือกไฟล์</label>
                                        </div>
                                        <p class="file-return" ></p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="profile">สถานะ<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="status" id="" class="form-control" required>
                                            <option value="">เลือกสถานผู้ใช้งาน</option>
                                            <option value="1" <?php echo($rs->status_id == 1?'selected="selected"':'')?>>ผู้ดูแลระบบ</option>
                                            <option value="2"<?php echo($rs->status_id == 2?'selected="selected"':'')?>>หมอนวด</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-lg btn-block btn-primary" name="update">บันทึกข้อมูล</button>
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
    <?php
            }
            $stmt->close();
        }
        $mysqli->close();
    ?>
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
