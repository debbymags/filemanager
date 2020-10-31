<?php
    session_start();
?>

<!-- HEADER FILE. Include in all web pages -->
<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="css/style.css?v=1">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://use.fontawesome.com/a553b9ef43.js"></script>
    <title></title>
</head>

<body>
    <div class="topnav">
        <a href="index.php">Home</a>
        <?php
            if(isset($_SESSION["userid"])){
                echo "<a href='includes/logout.inc.php'>Log out</a>";
            }
            else {
                echo "<a href='signup.php'>Sign up</a>";
                echo "<a href='login.php'>Log in</a>";
            }
        ?>
    </div>
</body>

</html>