<?php
    include_once 'header.php';
?>

<!-- LOG IN form -->
<div class="main">
    <p class="sign" align="center">Log in</p>
    <form class="form1" action="includes/login.inc.php" method="POST">
        <input class="un" type="text" align="center" name="username" placeholder="Username/Email">
        <input class="pass" type="password" align="center" name="pwd" placeholder="Password">
        <button class="submit" type='submit' align="center" name='submit'>Log in</button>
    </form>
</div>



<!-- error messages -->
<?php
    if(isset($_GET["error"])){
        if($_GET["error"] == "emptyinput"){
            echo "<p id='display-error'>Fill in all fields!</p>";
        }
        else if($_GET["error"] == "wronglogin"){
            echo "<p id='display-error'>Incorrect login details!</p>";
        }
    }
?>


<?php
    include_once 'footer.php';
?>