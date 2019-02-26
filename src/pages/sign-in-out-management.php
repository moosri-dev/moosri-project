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

        $sql2 = "SELECT u.user_id as uid, u.user_name as uname, w.status as st  
        FROM hm_user u LEFT JOIN hm_works w ON u.user_id = w.user_id WHERE u.status_id = ?";

        if($stmt = $mysqli->prepare($sql2)){
            $st = 2;
            $stmt->bind_param("s",$st);

            if($stmt->execute()){
                $result  = $stmt->get_result();
                while($rs=$result->fetch_object()){
                    $userList[$rs->uid] = $rs->uname;
                    $statusList[$rs->uid] = $rs->st;
                }
            }
            $stmt->close();
        }
        $mysqli->close();

    ?>
</head>

<body>
    <div id="wrapper">
        <?php include('../components/menu.php'); ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">จัดการข้อมูลเวลาทำงาน</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                จัดการเวลาทำงาน
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <form name="myForm" method="post">
                                    <div class="row">
                                      <?php foreach($userList as $key => $value){?>
                                        <div class="col-md-3">
                                            <div class="card-container">
                                                <div class="card-header">
                                                    <div class="title">
                                                        ชื่อพนักงาน:
                                                    </div>
                                                    <div class="subTitle">
                                                        <?php echo $value;?>
                                                    </div>
                                                </div>
                                                <div class="card-content">
                                                    <div class="card-label">
                                                        สถานะ:
                                                    </div>
                                                    <div class="card-value">
                                                        <?php 
                                                            if($statusList[$key] == 1){
                                                                 echo "<span style='color:green; font-weight:700;'>ลงชื่อเข้าทำงานแล้ว</span>";
                                                            }else{
                                                                echo "<span>ยังไม่ได้ลงชื่อเข้าทำงาน</span>";
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <?php if($statusList[$key] != 1){?>
                                                        <button type="button" class="btn btn-block btn-md btn-success" name="btnSave" id="btnSave" onclick="signIn(<?php echo $key.',\''.$value.'\'';?>)">ลงชื่อเข้างาน</button>
                                                    <?php }else{ ?>
                                                        <button type="button" class="btn btn-block btn-md btn-danger" name="btnUpdate" id="btnUpdate" onclick="signOut(<?php echo $key.',\''.$value.'\'';?>)">ลงชื่อออกงาน</button>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                      <?php }?>
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
            <!-- /container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
</body>

    <script type="text/javascript">
       function signIn(uid,uname){
            if(confirm("ยืนยันลงชื่อเข้างาน: "+uname)){
                $.post('pages/sign-in.php','uid='+uid,function(response){
               if(response){
                    alert("ลงชื่อเข้างานสำเร็จ!!");
                    location.reload();
               }else{
                   alert('ลงชื่อเข้างานล้มเหลว.');
                }
             });
            }
        }

        function signOut(uid,uname){
            if(confirm("ยืนยันลงชื่อออกงาน: "+uname)){
                $.post('pages/sign-out.php','uid='+uid,function(response){
               if(response){
                    alert("ลงชื่อออกงานสำเร็จ!!");
                    location.reload();
               }else{
                   alert('ลงชื่อออกงานล้มเหลว.');
                }
             });
            }
        }
    </script>

</html>
