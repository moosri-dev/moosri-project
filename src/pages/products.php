<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <meta http-equiv="refresh" content="0;url="> -->
    <title>ศูนย์นวดแผนไทยหมู่สี</title>
    <!--    Style Sheet -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="../assets/css/style.css"> -->
    <link rel="stylesheet" href="../assets/css/booking.css">
    <link rel="stylesheet" href="../assets/css/datepicker.css">

</head>

<body>
    <div class="header">
        <?php include "../components/header.php";?>
    </div>

    <div class="container">
        <div>
            <p>
                <h4 class="text-center topic_h"
                    style="background: pink;margin-left:5%;width:250px;height:40px;padding-top:3px;border: 1px solid pink">
                    สินค้าของร้านเรา</h4>
            </p>
        </div>
        <div class="col-md-12">
            <div class="row">
            <?php
                include ("../config/connect-db.php");
                $sql = "SELECT * FROM hm_product";
                if ($sQuery = $mysqli->prepare($sql)) {
                    $sQuery->execute();
                    $result = $sQuery->get_result();
                    while ($rs = $result->fetch_object()) {
            ?>
            <div class="r1 card" style="width: 17rem;margin:10px 10px 30px 10px;padding:10px 0px 30px 0px;">
                <img class="card-img-top" style="height:190px;" src="../uploads/<?=$rs->product_img?>" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><?=$rs->product_name?></h5>
                    <p class="card-text"><?=$rs->product_detail?></p>
                    <p class="card-text">ราคา <?=$rs->product_price?> บาท</p>
                </div>
            </div>
            <?php }}?>
            </div>
        </div>
    </div>

    <div class="footer">
        <?php include "../components/footer.php";?>
    </div>
</body>
<!-- Script -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
</script>