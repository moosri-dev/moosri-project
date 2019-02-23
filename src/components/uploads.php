<?php
    $file_name = $_FILES['fileToUpload']['name'];
    $temp_name = $_FILES['fileToUpload']['tmp_name'];
    $file_err = $_FILES['fileToUpload']['error'];
    $file_size = $_FILES['fileToUpload']['size'];
    $location = '../uploads';
    $file_destination="";
    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));
    $file_allow = array('jpg', 'jpeg', 'png');
    if (in_array($file_ext, $file_allow)) {
        if ($file_err === 0) {
            if ($file_size <= 2097152) {
                $file_name_new = uniqid('', true) . '.' . $file_ext;
                $file_destination = $location . '/' . $file_name_new;
            }
        }
    }
?>