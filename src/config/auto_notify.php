#!/usr/bin/php -q
<?php
$con = mysqli_connect("localhost", "root", "", "moosi-massage");
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    mysqli_set_charset($con, 'utf8');
}

$sql = "SELECT bk_id, bk_fullname, MOD( HOUR( TIMEDIFF(bk_time, CURRENT_TIME())), 24 ), MOD( MINUTE( TIMEDIFF(bk_time, CURRENT_TIME())), 60 ) as minute FROM hm_booking_details WHERE CURRENT_TIME() < bk_time AND MOD( HOUR( TIMEDIFF(bk_time, CURRENT_TIME())), 24 ) = 0 AND MOD( MINUTE( TIMEDIFF(bk_time, CURRENT_TIME())), 60 ) < 30 AND status = 1";

if ($result = mysqli_query($con, $sql)) {
    // Return the number of rows in result set
    $rowcount = mysqli_num_rows($result);
    if ($rowcount > 0) {
        while ($r = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $msg = "สวัสดีค่ะ คุณ " . $r['bk_fullname'] . "  เหลือเวลาอีก " . $r['minute'] . " นาที จะถึงคิวนวดของคุณ กรุณาเข้ามาก่อนถึงเวลานวด 10 นาทีค่ะ";
            $id = $r['bk_id'];
            var_dump($id);
            $qry = mysqli_query($con, "UPDATE hm_booking_details tbk SET tbk.status = '2' WHERE tbk.bk_id = $id ");
            execUrl($msg);//เรียกใช้ function เพื่อส่ง Notify Line ไปในแชท
        }
    }
}
mysqli_close($con);

function execUrl($ms)
{
    $message = $ms;
    $chOne = curl_init();
    curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    // SSL USE
    curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
    //POST
    curl_setopt($chOne, CURLOPT_POST, 1);
    // Message
    curl_setopt($chOne, CURLOPT_POSTFIELDS, $message);
    // parameter imageThumbnail imageFullsize
    curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=$message");
    // follow redirects
    curl_setopt($chOne, CURLOPT_FOLLOWLOCATION, 1);
    //ADD header array
    $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ij8zzguel0X9Cco0S1cM89FvztEB51h3VHhrKuPkPsG'); //  Bearer  line authen code �
    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
    //RETURN
    curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($chOne);
    //Check error
    // if (curl_error($chOne)) {echo 'error:' . curl_error($chOne);} else { $result_ = json_decode($result, true);
    //     echo "<br>status : " . $result_['status'];
    //     echo "<br>message : " . $result_['message'];}
    //Close connect
    curl_close($chOne);
}
