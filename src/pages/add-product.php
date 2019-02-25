<?php
    if(session_status() == PHP_SESSION_NONE) 
    { 
        session_start(); 
    }

    if(!isset($_SESSION['user_id'])){
        header('location: /moosri-project/');
    }
?>
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
            include('../components/uploads.php');
            move_uploaded_file($temp_name, $file_destination);
            include('../config/connect-db.php');
            $image = $file_name_new;
            $pname = $_POST['pname'];
            $price = $_POST['price'];
            $unit = $_POST['unit'];
            $detail = $_POST['detail'];
            $user_id = $_SESSION['user_id'];
            $sql = "INSERT INTO 
            hm_product(product_name,product_detail,product_price,product_unit,product_img,user_id) 
            VALUES(?,?,?,?,?,?)";

            /* create a prepared statement */
            if($stmt = $mysqli->prepare($sql)){

                /* bind parameters for markers */
                $stmt->bind_param('ssiisi',$pname,$detail,$price,$unit,$image,$user_id);
                
                /* execute query */
                if($stmt->execute()){
                    include ("../components/uploads.php");
                    echo "Insert data success!";
                    header('location: product-management.php');
                }else{
                    echo "Error:".$sql."<br>".$mysqli->error;
                    header('refresh:2;');
                }
                /* close statement */
                $stmt->close();
                
            }else{
                echo "Error:".$sql."<br>".$mysqli->error;
                header('refresh:2;');
            }
            $mysqli->close();

            exit(0);
        }
    ?>
</head>

<body>
    <div id="wrapper">
        <?php include('../components/menu.php'); ?>
        <div id="page-wrapper">

        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">จัดการข้อมูลสินค้า</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
            <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            เพิ่มข้อมูลสินค้า
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="inputPname">ชื่อสินค้า<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="pname" class="form-control" placeholder='ชื่อสินค้า' maxlength='50' required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="inputPrice">ราคา<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" name="price" class="form-control" placeholder='ราคาต่อหน่วย' maxlength='50' required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="unit">จำนวน<span class="required">*</span> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" name="unit" class="form-control" placeholder='จำนวน' maxlength='50' required/>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="detail">รายละเอียด :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <textarea name="detail"rows="3" class="form-control" placeholder='รายละเอียดสินค้า'></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4 text-right">
                                        <label for="profile">รูปสินค้า :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="input-file-container">  
                                            <input class="input-file" name="fileToUpload" id="fileToUpload" type="file">
                                            <label tabindex="0" for="my-file" class="input-file-trigger">เลือกไฟล์</label>
                                        </div>
                                        <p class="file-return"></p>
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
            the_return.innerHTML = this.value.replace("C:\\fakepath\\","");  
        });  
    </script>
    
</body>
</html>
