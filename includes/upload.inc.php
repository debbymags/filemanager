<?php

if(isset($_POST['upload'])){
    
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $file = $_FILES['file'];
    $access = $_POST['access'];

    //call function to upload file
    uploadFile($conn, $file, $access);
}
