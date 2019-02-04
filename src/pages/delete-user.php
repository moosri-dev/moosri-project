<?php 
    include('../config/connect-db.php');
    
    $userId = $_POST['userId'];
    $sql = "DELETE FROM hm_user WHERE id = ?";
   
    /* create a prepared statement */
    if($stmt = $mysqli->prepare($sql)){

         /* bind parameters for markers */
        $stmt->bind_param('i',$userId);
        
        /* execute query */
        $stmt->execute();

        /* close statement */
        $stmt->close();

        echo true;
    }else{
        echo false;

    }
    /* close connection */
    $mysqli->close();
    exit(0);
?>