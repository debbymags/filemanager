<?php
    include_once 'header.php';
?>

<?php
    if(isset($_SESSION["userid"])){
        echo "<p>Hello there ".$_SESSION["username"]."</p>";
    }
?>

<h>
    PUBLIC FILES
</h>

<?php
    if(isset($_SESSION["userid"])){
        echo "<form>";
        echo "<form action='includes/publicupload.inc.php' method='POST' enctype='multipart/form-data'>";
        echo "<input type='file' name='file'>";
        echo "<button type='submit' name='upload'>UPLOAD</button>";
        echo "</form>";
    }
?>

<?php>
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $access;
    if(isset($_SESSION["userid"])){
        $access = true;
    } 
    else {
        $access = false;
    }

    $filelist = displayFiles($conn, $access);
    if ($filelist !== false){
        echo "<a href='public/".$filelist["fname"]."'>".$filelist["fname"]."</a>";
    }


    if($access){
        echo "<h> PRIVATE FILES </h>";
        echo "<form>";
        echo "<form action='includes/privateupload.inc.php' method='POST' enctype='multipart/form-data'>";
        echo "<input type='file' name='file'>";
        echo "<button type='submit' name='upload'>UPLOAD</button>";
        echo "</form>";
        
        $filelist = displayFiles($conn, $access);
        if ($filelist !== false){

        }
    }
?>


<?php
    include_once 'footer.php';
?>