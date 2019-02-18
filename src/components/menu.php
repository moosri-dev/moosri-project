<?php
    if(session_status() == PHP_SESSION_NONE) 
    { 
        session_start(); 
    }

    if(!isset($_SESSION['user_id'])){
        header('location: /moosri-project/');
    }
?>
<!-- Navigation -->
<nav class="navbar navbar-static-top nav-container navbar-fixed-top" role="navigation">
    <div class="navbar-header">
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle profile" data-toggle="dropdown" href="#">
                <?php
                    echo "<img src ='uploads/".$_SESSION['user_img']."' class='image-profile'/> &nbsp&nbsp".$_SESSION['user_name'];
                ?>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li><a href="config/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="siderbar header">
            <?php
                echo "<img src ='uploads/".$_SESSION['user_img']."' class='image profile'/>";
            ?>
            <div class="name f-bold text-left">ชื่อ: <?php echo $_SESSION['user_name'] ?></div>
            <div class="name f-bold text-left">สถานะ: <?php echo $_SESSION['status_id']==1?'ผู้ดูแลระบบ':'หมอนวด' ?></div>

        </div>
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="pages/admin.php"><i class="fa fa-dashboard fa-fw"></i>&nbsp&nbsp&nbsp&nbspหน้าแรก</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-users" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbspจัดการข้อมูลผู้ใช้งาน<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="pages/admin-management.php"><i class="fa fa-male" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbspข้อมูลเจ้าหน้าที่ดูแลระบบ</a>
                        </li>
                        <li>
                            <a href="pages/massager-management.php"><i class="fa fa-female" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbspข้อมูลหมอนวด</a>
                        </li>
                        <li>
                            <a href="pages/add-user.php"><i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbspเพิ่มข้อมูลผู้ใช้งาน</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-product-hunt" aria-hidden="true"></i></i>&nbsp&nbsp&nbsp&nbspจัดการข้อมูลสินค้า<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="pages/product-management.php"><i class="fa fa-info" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbspข้อมูลสินค้า</a>
                            </li>
                            <li>
                                <a href="pages/add-product.php"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbspเพิ่มสินค้า</a>
                            </li>
                        </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbspจัดการข้อมูลการขายสินค้า<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="pages/order-management.php"><i class="fa fa-cc" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbspรายการขายสินค้า</a>
                        </li>
                        <li>
                            <a href="pages/add-items.php"><i class="fa fa-money" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbspเพิ่มรายการขายสินค้า</a>
                        </li>
                    </ul>
                <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="pages/bill-report.php"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbspพิมพ์ใบเสร็จ</a>
                </li>

            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>