<?php

if(isset($_POST['upload'])){
    
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $file = $_FILES['file'];
    $access = "public";

    uploadFile($conn, $file, $access);
}