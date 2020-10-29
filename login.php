<?php
    include_once 'header.php';
?>


<h2> Log in</h2>
<form action="includes/login.inc.php" method="POST">
    
    <input type="text" name="username" placeholder="Username/Email">
    <input type="password" name="pwd" placeholder="Password">
    <button type='submit' name='submit'>LOG IN</button>
</form>


<?php
    if(isset($_GET["error"])){
        if($_GET["error"] == "emptyinput"){
            echo "<p>Fill in all fields!</p>";
        }
        else if($_GET["error"] == "wronglogin"){
            echo "<p>Incorrect login details!</p>";
        }
    }
?>


<?php
    include_once 'footer.php';
?>