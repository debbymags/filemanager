<?php
    include_once 'header.php';
?>
<h2> Sign Up</h2>
<form action="includes/signup.inc.php" method="POST">
    <input type="text" name="firstname" placeholder="First name">
    <input type="text" name="lastname" placeholder="Last name">
    <input type="text" name="email" placeholder="Email">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="pwd" placeholder="Password">
    <input type="password" name="pwdrepeat" placeholder="Repeat password">
    <button type='submit' name='submit'>SIGN UP</button>
</form>

<?php
    if(isset($_GET["error"])){
        if($_GET["error"] == "emptyinput"){
            echo "<p>Fill in all fields!</p>";
        }
        else if($_GET["error"] == "invalidusername"){
            echo "<p>Choose a proper username!</p>";
        }
        else if($_GET["error"] == "invalidemail"){
            echo "<p>Use a proper email!</p>";
        }
        else if($_GET["error"] == "passwordmismatch"){
            echo "<p>Passwords don't match!</p>";
        }
        else if($_GET["error"] == "usernametaken"){
            echo "<p>That username has been taken. Choose another</p>";
        }
        else if($_GET["error"] == "stmtfailed"){
            echo "<p>Something went wrong, try again!</p>";
        }
        else if($_GET["error"] == "none"){
            echo "<p>You have signed up!</p>";
        }
    }
?>

<?php
    include_once 'footer.php';
?>