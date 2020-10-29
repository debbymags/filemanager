<?php

function emptyInput($firstname, $lastname, $email, $username, $pwd, $pwdrepeat){
    $result;
    if(empty($firstname) || empty($lastname) || empty($email) || empty($username) || empty($pwd) || empty($pwdrepeat)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidUsername($username){
    $result;
    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email){
    $result;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function pwdMismatch($pwd, $pwdrepeat){
    $result;
    if($pwd != $pwdrepeat){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function usernameTaken($conn, $username, $email){
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $firstname, $lastname, $email, $username, $pwd){
    $sql = "INSERT INTO users (firstname, lastname, email, username, password) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssss", $firstname, $lastname, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
    exit();
}

function emptyInputLogin($username, $pwd){
    $result;
    if(empty($username) || empty($pwd)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd){
    $usernameExists = usernameTaken($conn, $username, $username);

    if($usernameExists === false){
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $usernameExists["password"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if($checkPwd === false){
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    else if($checkPwd === true){
        session_start();
        $_SESSION["userid"] = $usernameExists["uid"];
        $_SESSION["username"] = $usernameExists["username"];
        header("location: ../index.php");
        exit();
    }
}


function uploadFile($conn, $file, $access){
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
                $fileDestination = $access.'/'.$fileName;
                move_uploaded_file($fileTmpName, $fileDestination);
                header("Location: ../index.php?uploadsuccess");
                exit();
            } else{
                header("Location: ../index.php?filetoolarge");
                exit();
            }
        } else{
            header("Location: ../index.php?uploaderror");
            exit();
        }
    } else{
        header("Location: ../index.php?unacceptedtype");
        exit();
    }


    $sql = "INSERT INTO ".$access." (fname) VALUES (?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $fileName);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../index.php?error=none");
    exit();
}


function displayFiles($conn, $access){
    if ($access){
        $sql = "SELECT * FROM private;";
    }
    else{
        $sql = "SELECT * FROM public;";
    }

    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $rowCount = mysqli_num_rows($resultData);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }
    else {
        return false;
    }

    mysqli_stmt_close($stmt);
}
