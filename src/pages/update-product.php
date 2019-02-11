<?php
    if(session_status() == PHP_SESSION_NONE) 
    { 
        session_start(); 
    } 
     if(isset($_POST['update'])){
        include('../config/connect-db.php');
        $pid = $_POST['pid'];
        $pname = $_POST['pname'];
        $price = $_POST['price'];
        $unit = $_POST['unit'];
        $image = $_POST['image'];
        $detail = $_POST['detail'];
        $user_id = $_SESSION['user_id'];
        $sql = "UPDATE hm_product 
        SET product_name=?, product_detail=?, product_price=?, product_unit=?,product_img=?,user_id=?
        WHERE product_id=?";

        /* create a prepared statement */
        if($stmt = $mysqli->prepare($sql)){

            /* bind parameters for markers */
            $stmt->bind_param('ssdisii',$pname,$detail,$price,$unit,$image,$user_id,$pid);
            
            /* execute query */
            if($stmt->execute()){
                $lc='product-management.php';
                echo "Update data success!";
                header('refresh:2;url='.$lc);
            }else{
                echo "ERROR: update data failed.".$sql."<br>".$mysqli->error;
                header('refresh:2;');
            }
            /* close statement */
            $stmt->close();
            
        }else{
            echo "Error:".$sql."<br>".$mysqli->error;
            header('refresh:5;');
        }
        $mysqli->close();
        exit(0);
    }

?>