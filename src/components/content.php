<div class="h2Topic">
    <h2>ยินดีต้อนรับสู่ ศูนย์นวดแผนไทย ตำบลหมู่สี</h2>
    <hr class="underline_c">
</div>
<div class="row">
    <div class="col-md-4" style="text-align:right;">
        <img class="img_c" src="src/assets/images/logo.jpeg" alt="logo">
    </div>
    <div class="col-md-6 story">
        <h4>ประวัติศูนย์นวดแผนไทย ตำบลหมู่สี</h4>
        <hr class="underline_c_sub">
        <p>ศูนย์นวดแผนไทยตำบลหมูสี เริ่มก่อตั้งขึ้นเมื่อปี พ.ศ. 2549 ตั้งอยู่บ้ำนกุดคล้ำ เลขที่
            55/8 หมูที่5 ตำบลหมูสี อำเภอปำกช่อง จังหวัดนครรำชสีมำ 30130 เป็นศูนย์ส่งเสริมอำชีพที่จัดตั้ง
            ขึ้นโดยกองสวัสดิกำรสังคมเทศบำลต ำบลหมูสีได้สนับสนุนกลุ่มอำชีพนวดแผนไทยเพื่อให้กลุ่มสตรี
            แม่บ้ำนบุคคลทั่วไปในต ำบลที่สนใจได้มีงำนท ำมีรำยได้เลี้ยงชีพ โดยมี นำงนงค์ฉิมพลี วิชัยสุชำติ เป็น
            ประธำนกลุ่มผู้ริเริ่มก่อตั้ง ปัจจุบันกลุ่มนวดแผนไทยต ำบลหมูสีมีหมอนวดทั้งหมด 22 คน เปิด
            ให้บริกำรนวดทุกวันเวลำ 09:00 – 22:00 น.โดยกำรให้บริกำรนวดใช้กำรนวดแผนไทยแบบเชลยศักดิ์
            เป็นกำรนวดแบบพื้นบ้ำนที่ให้ควำมรู้สึกเป็นกันเองคือ ใช้ทั้งมือ เท้ำ เข่ำ ศอก ในกำรนวด อีกทั้งยังมี
            ท่ำดัดตัวเพื่อยืดกล้ำมเนื้อส่วนต่ำง ๆ เพื่อให้รู้สึกผ่อนคลำย</p>
    </div>
</div>
<hr>
<div class="row">
    <!-- Block 1 -->
    <div class="container">
        <div>
            <p>
                <h4 class="text-center topic_h"
                    style="background: pink;margin-left:5%;width:250px;height:40px;padding-top:3px;border: 1px solid pink">
                    รูปแบบการบริการ</h4>
            </p>
        </div>
        <div class="row">
            <div class="r1 card" style="width: 18rem;">
                <img class="card-img-top" src="src/assets/images/thai-massage3.jpg" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">นวดออยล์ อโรมา</h5>
                    <p class="card-text">1.5 ชั่วโมง</p>
                    <p class="card-text">400 บาท</p>
                </div>
            </div>
            <div class="r1 card" style="width: 18rem;">
                <img class="card-img-top" src="src/assets/images/thai-massage4.jpg" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">นวดไทย</h5>
                    <p class="card-text">2 ชั่วโมง</p>
                    <p class="card-text">300 บาท</p>
                </div>
            </div>
            <div class="r1 card" style="width: 18rem;">
                <img class="card-img-top" src="src/assets/images/219-335.gif" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">นวดเท้า</h5>
                    <p class="card-text">1.5 ชั่วโมง</p>
                    <p class="card-text">300 บาท</p>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:30px;">
            <div class="r1 card" style="width: 18rem;">
                <img class="card-img-top" src="src/assets/images/thai-massage1.jpg" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">นวดไทย - น้ำมัน</h5>
                    <p class="card-text">2 ชั่วโมง</p>
                    <p class="card-text">400 บาท</p>
                </div>
            </div>
            <div class="r1 card" style="width: 18rem;">
                <img class="card-img-top" style="height:190px;" src="src/assets/images/outdoor.jpg"
                    alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">นวดไทยนอกสถานที่</h5>
                    <p class="card-text">2 ชั่วโมง</p>
                    <p class="card-text">600 บาท</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Block 2 -->
    <div class="container">
        <div>
            <p>
                <h4 class="text-center topic_h"
                    style="background: pink;margin-left:5%;width:250px;height:40px;padding-top:3px;border: 1px solid pink">
                    สินค้าของร้านเรา</h4>
            </p>
        </div>
        <div class="row">
            <?php 
            include("src/config/connect-db.php");
            $sql = "SELECT * FROM hm_product";
            if ($sQuery = $mysqli->prepare($sql)) {
                $sQuery->execute();
                $result=$sQuery->get_result();
                while($rs=$result->fetch_object()){
            ?>
            <div class="r1 card" style="width: 18rem;padding:10px 0px 30px 0px ;">
                <img class="card-img-top" style="height:190px;" src="src/uploads/<?=$rs->product_img?>"
                    alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><?= $rs->product_name?></h5>
                    <p class="card-text"><?= $rs->product_detail?></p>
                    <p class="card-text">ราคา <?= $rs->product_price?> บาท</p>
                </div>
            </div>
                <?php } } ?>
        </div>
    </div>
    <!-- Block 3 -->
    <div class="container" style="margin-bottom: 150px;">
        <div>
            <p>
                <h4 class="text-center topic_h"
                    style="background: pink;margin-left:5%;width:250px;height:40px;padding-top:3px;border: 1px solid pink">
                    โปรโมชั่น</h4>
            </p>
        </div>
        <div>
        <div style="margin-left:50px;" id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="carousel_c d-block w-100" src="https://letsrelaxspa.com/wp-content/uploads/2018/07/Hand-Cream-5free1-TH.jpg?_t=1531792023" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="carousel_c d-block w-100" src="https://letsrelaxspa.com/wp-content/uploads/2018/12/TH-04-1.jpg?_t=1550114117" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="carousel_c d-block w-100" src="https://letsrelaxspa.com/wp-content/uploads/2018/07/Cash-Card-TH.jpg" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</div>