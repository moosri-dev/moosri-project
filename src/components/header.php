<?php 
 if(!isset($_SESSION)) 
 { 
     session_start(); 
 } 
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="src/assets/css/style.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<div>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color:pink">
            <a class="navbar-brand" href="../../">แนวแผน ไทยหมู่สี</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Guest -->
            <?php if(isset($_SESSION['status_id'])!=0){ ?>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="booking.php">จองคิวหมอนวด<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">สินค้า</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">ดูข้อมูลรายการนวดและรำคำค่ำบริกำร</a>
                    </li> -->
                </ul>
                <ul class="navbar-nav mr-rigth">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-male"></i>&nbsp;ยินดีต้อนรับคุณ <?= $_SESSION['user_name']; ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="profile.php"><i class="fas fa-user"></i>&nbsp;ข้อมูลส่วนตัว</a>
                            <a class="dropdown-item" href="products.php"><i class="fab fa-product-hunt"></i>&nbsp;ข้อมูลสินค้า</a>
                            <a class="dropdown-item" href="bookingList.php"><i class="fas fa-list-ol"></i>&nbsp;รายการนวด</a>
                            <a class="dropdown-item" href="booking.php"><i class="far fa-address-book"></i>&nbsp;จองคิวนวด</a>
                            <a class="dropdown-item" href="search.php"><i class="fas fa-search"></i>&nbsp;ค้นหาหมอนวด</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../../src/config/logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;ออกจากระบบ</a>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- User -->
            <?php }else{ ?>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">จองคิวหมอนวด<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">สินค้า</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">ดูข้อมูลรำยกำรนวดและรำคำค่ำบริกำร</a>
                    </li>
                </ul>
                <a href="src/pages/login.php" class="navbar-text">
                <i class="fas fa-sign-in-alt"></i>
                    เข้าสู่ระบบ
                </a>
            </div>
            <?php } ?>
        </nav>
    </div>
</div>

<!-- Import Script  -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>