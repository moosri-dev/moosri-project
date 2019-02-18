<?php
     if(isset($_POST['update'])){
        include('../config/connect-db.php');
        include("../components/uploads.php");
        if($file_destination != ""){
            move_uploaded_file($temp_name, $file_destination);
            unlink($location.'/'.$_POST['fileImage']);
            $image = $file_name_new;
        }else{
            $image = $_POST['fileImage'];
        }
        $userId = $_POST['userId'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $tel = $_POST['tel'];
        $email = $_POST['email'];
        $line = $_POST['line'];
        $address = $_POST['address'];
        $status = $_POST['status'];
        $sql = "UPDATE hm_user 
        SET user_user=?,user_pass=?,user_name=?,user_tel=?,user_email=?,user_line=?,user_address=?,user_img=?,status_id=? 
        WHERE user_id=?";

        /* create a prepared statement */
        if($stmt = $mysqli->prepare($sql)){

            /* bind parameters for markers */
            $stmt->bind_param('ssssssssii',$username,$password,$name,$tel,$email,$line,$address,$image,$status,$userId);
            
            /* execute query */
            if($stmt->execute()){
                $lc=$status == 1?'admin-management.php':'massager-management.php';
                echo "Update data success!";
                header('Refresh:3;url='.$lc);
            }else{
                echo "ERROR: update data failed.".$sql."<br>".$mysqli->error;
                header('Refresh:5;url='.$lc);
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