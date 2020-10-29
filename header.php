<?php
    session_start();
?>

<!DOCTYPE html>

<head>
    <title> </title>
</head>

<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php
                if(isset($_SESSION["userid"])){
                    echo "<li><a href='includes/logout.inc.php'>Log out</a></li>";
                }
                else {
                    echo "<li><a href='signup.php'>Sign up</a></li>";
                    echo "<li><a href='login.php'>Log in</a></li>";
                }
            ?>
            
            
        </ul>
    </nav>
</body>

</html>