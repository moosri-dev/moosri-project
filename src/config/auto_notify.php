<?php

$con = mysqli_connect("localhost", "root", "", "moosi-massage");
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    echo "Connect OK <br>";
    mysqli_set_charset($con,'utf8');
}

$sql = "SELECT bk_fullname, MOD( HOUR( TIMEDIFF(bk_time, CURRENT_TIME())), 24 ), MOD( MINUTE( TIMEDIFF(bk_time, CURRENT_TIME())), 60 ) as minute FROM hm_booking_details WHERE MOD( HOUR( TIMEDIFF(bk_time, CURRENT_TIME())), 24 ) = 0 AND MOD( MINUTE( TIMEDIFF(bk_time, CURRENT_TIME())), 60 ) < 30 AND status = 1";

if ($result = mysqli_query($con, $sql)) {
    // Return the number of rows in result set
    $rowcount = mysqli_num_rows($result);
    printf("\n Result set has %d rows.\n", $rowcount);
    if ($rowcount > 0) {
        while($r=mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $msg = "สวัสดีค่ะ คุณ ".$r['bk_fullname']."  เหลือเวลาอีก ".$r['minute']." นาที จะถึงคิวนวดของคุณ กรุณาเข้ามาก่อนถึงเวลานวด 10 นาทีค่ะ";
            echo "<iframe src='http://localhost/moosri-project/src/config/line_notify.php?message=$msg'></iframe>";
        }
    }
}
mysqli_close($con);
