<?php 
    include('../config/connect-db.php');
    date_default_timezone_set("Asia/Bangkok");
    
    $uid = $_POST['uid'];
    $spDate = explode('/',date('d/m/Y'));
    $day = $spDate[0];
    $month = $spDate[1];
    $year = (int)$spDate[2]+543;
    $ctime = date('H:i:s',time());
    $startDate = $day."/".$month."/".$year.":".$ctime;



    $sql = "INSERT INTO hm_works(user_id,start_date,status) VALUES(?,?,?)";

    if($stmt = $mysqli->prepare($sql)){
        $st = 1;
        $stmt->bind_param("isi",$uid,$startDate,$st);
        if($stmt->execute()){
            echo true;
        }else{
            echo false;
        }
        $stmt->close();
    }
    $mysqli->close();
?>