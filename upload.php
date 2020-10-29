<?php
if(isset($_POST['upload'])){
    $file = $_FILES['file'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'txt');

    if(in_array($fileActualExt, $allowed)){
        if($fileError===0){
            if($fileSize < 50000000){
                $fileDestination = 'public/'.$fileName;
                move_uploaded_file($fileTmpName, $fileDestination);
                header("Location: index.php?uploadsuccess");
                exit();
            } else{
                header("Location: index.php?filetoolarge");
                exit();
            }
        } else{
            header("Location: index.php?uploaderror");
            exit();
        }
    } else{
        header("Location: index.php?unacceptedtype");
        exit();
    }
}