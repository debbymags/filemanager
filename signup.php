<?php
    include_once 'header.php';
?>


<!-- SIGN UP form -->
<div class="mainr">
<p class="sign" align="center">Sign Up</p>
<form class="form1" action="includes/signup.inc.php" method="POST">
    <input class="un" type="text" align="center" name="firstname" placeholder="First name">
    <input class="un" type="text" align="center" name="lastname" placeholder="Last name">
    <input class="un" type="text" align="center" name="email" placeholder="Email">
    <input class="un" type="text" align="center" name="username" placeholder="Username">
    <input class="pass"type="password" align="center" name="pwd" placeholder="Password">
    <input class="pass"type="password" align="center" name="pwdrepeat" placeholder="Repeat password">
    <button class="submit" type='submit' align="center" name='submit'>Sign up</button>
</form>
</div>



<!-- error messages -->
<?php
    if(isset($_GET["error"])){
        if($_GET["error"] == "emptyinput"){
            echo "<p id='display-error'>Fill in all fields!</p>";
        }
        else if($_GET["error"] == "invalidusername"){
            echo "<p id='display-error'>Choose a proper username!</p>";
        }
        else if($_GET["error"] == "invalidemail"){
            echo "<p id='display-error'>Use a proper email!</p>";
        }
        else if($_GET["error"] == "passwordmismatch"){
            echo "<p id='display-error'>Passwords don't match!</p>";
        }
        else if($_GET["error"] == "usernametaken"){
            echo "<p id='display-error'>That username has been taken. Choose another</p>";
        }
        else if($_GET["error"] == "stmtfailed"){
            echo "<p id='display-error'>Something went wrong, try again!</p>";
        }
        else if($_GET["error"] == "none"){
            echo "<p id='display-success'>You have signed up!</p>";
        }
    }
?>

<?php
    include_once 'footer.php';
?>