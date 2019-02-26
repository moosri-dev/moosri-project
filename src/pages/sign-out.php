<?php 
    include('../config/connect-db.php');
    date_default_timezone_set("Asia/Bangkok");
    
    $uid = $_POST['uid'];
    $spDate = explode('/',date('d/m/Y'));
    $day = $spDate[0];
    $month = $spDate[1];
    $year = (int)$spDate[2]+543;
    $ctime = date('H:i:s',time());
    $endDate = $day."/".$month."/".$year.":".$ctime;



    $sql = "UPDATE hm_works SET end_date =?, status = ? WHERE user_id = ?";

    if($stmt = $mysqli->prepare($sql)){
        $st = 0;
        $stmt->bind_param("sii",$endDate,$st,$uid);
        if($stmt->execute()){
            echo true;
        }else{
            echo false;
        }
        $stmt->close();
    }
    $mysqli->close();
?>