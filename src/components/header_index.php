<?php 
 if(!isset($_SESSION)) 
 { 
     session_start(); 
 } 
?>
<div>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color:pink">
            <a class="navbar-brand" href="#">แนวแผน ไทยหมู่สี</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Guest -->
            <?php if(isset($_SESSION['status_id'])!=0){ ?>
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
                <ul class="navbar-nav mr-rigth">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-male"></i>&nbsp;ยินดีต้อนรับคุณ <?= $_SESSION['user_name']; ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="src/pages/profile.php"><i class="fas fa-user"></i>&nbsp;ข้อมูลส่วนตัว</a>
                            <a class="dropdown-item" href="#"><i class="fab fa-product-hunt"></i>&nbsp;ข้อมูลสินค้า</a>
                            <a class="dropdown-item" href="src/pages/bookingList.php"><i class="fas fa-list-ol"></i>&nbsp;รายการนวด</a>
                            <a class="dropdown-item" href="src/pages/booking.php"><i class="far fa-address-book"></i>&nbsp;จองคิวนวด</a>
                            <a class="dropdown-item" href="src/pages/search.php"><i class="fas fa-search"></i>&nbsp;ค้นหาหมอนวด</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="src/config/logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;ออกจากระบบ</a>
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