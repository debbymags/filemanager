<?php

if(isset($_POST["submit"])){
    
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $pwdrepeat = $_POST["pwdrepeat"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    
    if(emptyInput($firstname, $lastname, $email, $username, $pwd, $pwdrepeat) !== false){
        header("location: ../signup.php?error=emptyinput");
        exit();
    }

    if(invalidUsername($username) !== false){
        header("location: ../signup.php?error=invalidusername");
        exit();
    }

    if(invalidEmail($email) !== false){
        header("location: ../signup.php?error=invalidemail");
        exit();
    }

    if(pwdMismatch($pwd, $pwdrepeat) !== false){
        header("location: ../signup.php?error=passwordmismatch");
        exit();
    }

    if(usernameTaken($conn, $username, $email) !== false){
        header("location: ../signup.php?error=usernametaken");
        exit();
    }

    createUser($conn, $firstname, $lastname, $email, $username, $pwd);

}
else{
    header("location: ../signup.php");
    exit();
}