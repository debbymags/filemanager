<?php
$buttonname = $_POST['buttonname'];
if(isset($buttonname)){

    $folder = $_POST['access'];
    $name = $_POST['filename'];
    $path = $_POST['fileurl'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    //call function to delete file from database
    deleteFile($conn, $name, $folder);

    //delete file from folder
    if(!unlink("../".$path)){
        header("location: ../index.php?error=deleteerror");
        exit();
    }
    else{
        header("location: ../index.php?error=deletesuccess");
        exit();
    }
}