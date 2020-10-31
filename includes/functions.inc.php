<?php

//function to check if sign up form input is empty
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

//function to check if sign up username is valid
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

//function to check if sign up email is valid
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

//function to check if sign up password and password repeat fields match
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

//function to check if sign up username is available
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
        //store query result of username search
        return $row;
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

//function to register user in the database
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

//function to log in user
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

//function to upload file to database and file folder
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
                $fileNewName = rtrim(str_replace(' ', '', $fileName), $fileActualExt).uniqid().".".$fileActualExt;
                $fileDestination = '../'.$access.'/'.$fileNewName;
                move_uploaded_file($fileTmpName, $fileDestination);
            } 
            else{
                header("Location: ../index.php?filetoolarge");
                exit();
            }
        }
        else{
            header("Location: ../index.php?uploaderror");
            exit();
        }
    }
    else{
        header("Location: ../index.php?unacceptedtype");
        exit();
    }


    $sql = "INSERT INTO ".$access." (fname) VALUES (?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $fileNewName);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../index.php?error=uploadsuccess");
    exit();
}

//function to display all files available in the database
function displayFiles($conn, $access){
  
    $sql = "SELECT * FROM ".$access.";";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $rowCount = mysqli_num_rows($resultData);

    $rows[] = mysqli_fetch_assoc($resultData);
    while ($row = mysqli_fetch_assoc($resultData)){
        $rows[]=$row;
    }
    return array($rowCount, $rows);

    mysqli_stmt_close($stmt);
}

//function to delete file from database
function deleteFile($conn, $name, $folder){
    $sql = "DELETE FROM ".$folder." WHERE fname = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
