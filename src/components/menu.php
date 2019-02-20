<?php
    if(session_status() == PHP_SESSION_NONE) 
    { 
        session_start(); 
    }

    if($_SESSION['status_id'] != 1){
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
            <div class="name f-bold text-left" style="color: royalblue;">ชื่อ: <?php echo $_SESSION['user_name'] ?></div>
            <div class="name f-bold text-left" style="color: royalblue;">สถานะ: <?php echo $_SESSION['status_id']==1?'ผู้ดูแลระบบ':'หมอนวด' ?></div>

        </div>
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="pages/admin.php"><i class="fa fa-dashboard fa-fw"></i>&nbsp&nbsp&nbsp&nbsp หน้าแรก</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-users" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbsp จัดการข้อมูลผู้ใช้งาน<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="pages/admin-management.php"><i class="fa fa-male" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbsp ข้อมูลเจ้าหน้าที่ดูแลระบบ</a>
                        </li>
                        <li>
                            <a href="pages/massager-management.php"><i class="fa fa-female" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbsp ข้อมูลหมอนวด</a>
                        </li>
                        <li>
                            <a href="pages/add-user.php"><i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbsp เพิ่มข้อมูลผู้ใช้งาน</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-product-hunt" aria-hidden="true"></i></i>&nbsp&nbsp&nbsp&nbsp จัดการข้อมูลสินค้า<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="pages/product-management.php"><i class="fa fa-info" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbsp ข้อมูลสินค้า</a>
                            </li>
                            <li>
                                <a href="pages/add-product.php"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbsp เพิ่มสินค้า</a>
                            </li>
                        </ul>
                    <!-- /.nav-second-level -->
                </li>

                <li>
                    <a href="#"><i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbsp จัดการข้อมูลการขายสินค้า<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="pages/order-management.php"><i class="fa fa-cc" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbsp รายการขายสินค้า</a>
                        </li>
                        <li>
                            <a href="pages/add-items.php"><i class="fa fa-money" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbsp เพิ่มรายการขายสินค้า</a>
                        </li>
                        <li>
                            <a href="pages/bill-report.php"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbsp พิมพ์รายการขายสินค้า</a>
                        </li>
                    </ul>
                <!-- /.nav-second-level -->
                </li>

                <li>
                    <a href="#"><i class="fa fa-bath" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbsp จัดการข้อมูลรายการนวด<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="pages/booking-management.php"><i class="fa fa-street-view" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbsp ข้อมูลรายการนวด</a>
                        </li>
                        <li>
                            <a href="pages/add-booking.php"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbsp เพิ่มรายการนวด</a>
                        </li>
                    </ul>
                <!-- /.nav-second-level -->
                </li>

                <li>
                    <a href="#"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbsp จัดการข้อมูลการจอง<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="pages/booking-details-management.php"><i class="fa fa-calendar-check-o" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbsp ข้อมูลจองรายการนวด</a>
                        </li>
                        <li>
                            <a href="pages/add-booking-details.php"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i>&nbsp&nbsp&nbsp&nbsp เพิ่มข้อมูลการจอง</a>
                        </li>
                    </ul>
                <!-- /.nav-second-level -->
                </li>
                
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>