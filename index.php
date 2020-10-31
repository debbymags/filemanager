<?php
    // include header file
    include_once 'header.php';
?>

<?php
    if(isset($_SESSION["userid"])){
        echo "<p id='display-success'>You are signed in as ".$_SESSION["username"]."</p>";
    }
?>


<div class="row">
    <!-- assign PUBLIC FILES a column on the web page -->
    <div class="column">
        <h class="sign2">
            PUBLIC FILES
        </h>


        <?php
            // If user is logged in, display file upload form
            if(isset($_SESSION["userid"])){
                echo "<form action='includes/upload.inc.php' method='POST' enctype='multipart/form-data'>";
                echo "<input type='file' name='file'>";
                echo "<button class='submit2' type='submit' name='upload'>UPLOAD</button>";
                echo "<input type='hidden' name='access' value='public'>";
                echo "</form>";
                echo "<br>";
                echo "<br>";
            }
        ?>

        <!-- search field for public files -->
        <div class ="inputContainer">
            <i class="fa fa-search icon position-absolute"></i> 
            <input type="text" class= "un2" id="searchInput" onkeyup="myFunction()" placeholder="Search for public files..">
        </div>

        <?php
            require_once 'includes/dbh.inc.php';
            require_once 'includes/functions.inc.php';

            $access = "public";
            $filelist = displayFiles($conn, $access);
            if ($filelist !== false){
                $count = $filelist[0];

                //PUBLIC FILES table
                echo "<table class='styled-table' id='publicTable'>";
                echo "<thead><tr><th>Public Files</th></tr></thead><tbody>";
                
                while($count>0){
                    $filename = $filelist[1][$filelist[0]-$count]['fname'];
                    $fileurl = "public/".$filename;
                    $delete = "delete".$count;

                    echo "<tr><td>".($filelist[0]-$count+1)."</td><td>";
                    echo $filename;
                    echo "</td><td>";

                    echo "<button class='submit1' onclick=window.location.href='".$fileurl."';>DOWNLOAD</button>";
                    echo "</td>";

                    //If user is logged in, display file delete button
                    if(isset($_SESSION["userid"])){
                        echo "<td>";
                        echo "<form action='includes/deletefile.inc.php' method='post'>";
                        echo "<button class='submit1' type='submit' name=".$delete.">DELETE</button>";
                        echo "<input type='hidden' name='buttonname' value=".$delete.">";
                        echo "<input type='hidden' name='access' value=".$access.">";
                        echo "<input type='hidden' name='filename' value=".$filename.">";
                        echo "<input type='hidden' name='fileurl' value=".$fileurl.">";
                        echo "</form>";
                        echo "</td>";
                    }
                    echo "</tr>";
                    $count = $count-1;
                }
                echo "</tbody></table>";
            }
        ?>
    </div>

    <!-- assign PRIVATE FILES a column on the web page -->
    <div class="column">
        <?php
            //If user is logged in, display PRIVATE FILES table
            if(isset($_SESSION["userid"])){
                echo "<h class='sign2'> PRIVATE FILES </h>";
                echo "<form action='includes/upload.inc.php' method='post' enctype='multipart/form-data'>";
                echo "<input type='file' name='file'>";
                echo "<button class='submit2' type='submit' name='upload'>UPLOAD</button>";
                echo "<input type='hidden' name='access' value='private'>";
                echo "</form>";
                echo "<br>";
                echo "<br>";

                //search field for private files
                echo "<div class ='inputContainer'>";
                echo "<i class='fa fa-search icon position-absolute'></i>";
                echo "<input type='text'  class= 'un2' id='searchInput2' onkeyup='myFunction2()' placeholder='Search for private files..'>";
                echo "</div>";

                $access = "private";
                $filelist = displayFiles($conn, $access);
                if ($filelist !== false){
                    $count = $filelist[0];

                    echo "<table class='styled-table' id='privateTable'>";
                    echo "<thead><tr><th>Public Files</th></tr></thead><tbody>";

                    while($count>0){
                        $filename = $filelist[1][$filelist[0]-$count]['fname'];
                        $fileurl = "private/".$filename;
                        $delete = "delete".$count;

                        echo "<tr><td>".$count."</td><td>";
                        echo $filename;
                        echo "</td><td>";

                        echo "<button class='submit1' onclick=window.location.href='".$fileurl."';>DOWNLOAD</button>";
                        echo "</td>";

                        if(isset($_SESSION["userid"])){

                            echo "<td>";
                            echo "<form action='includes/deletefile.inc.php' method='post'>";
                            echo "<button class='submit1' type='submit' name=".$delete.">DELETE</button>";
                            echo "<input type='hidden' name='buttonname' value=".$delete.">";
                            echo "<input type='hidden' name='access' value=".$access.">";
                            echo "<input type='hidden' name='filename' value=".$filename.">";
                            echo "<input type='hidden' name='fileurl' value=".$fileurl.">";
                            echo "</form>";
                            echo "</td>";
                        }
                        echo "</tr>";
                        $count = $count-1;
                    }
                    echo "</tbody></table>";
                }
            }
        ?>

    </div>
</div>



<!-- error messages -->
<?php
    if(isset($_GET["error"])){
        if($_GET["error"] == "filetoolarge"){
            echo "<p id='display-error'>The file is too large!</p>";
        }
        else if($_GET["error"] == "uploaderror"){
            echo "<p id='display-error'>The file could not be uploaded!</p>";
        }
        else if($_GET["error"] == "unacceptedtype"){
            echo "<p id='display-error'>This file type cannot be uploaded!</p>";
        }
        else if($_GET["error"] == "stmtfailed"){
            echo "<p id='display-error'>Something went wrong. Try again!</p>";
        }
        else if($_GET["error"] == "uploadsuccess"){
            echo "<p id='display-success'>File uploaded successfully!</p>";
        }
        else if($_GET["error"] == "deleteerror"){
            echo "<p id='display-error'>The file could not be deleted!</p>";
        }
        else if($_GET["error"] == "deletesuccess"){
            echo "<p id='display-success'>File deleted successfully!</p>";
        }
    }
?>

<!-- include footer file -->
<?php
    include_once 'footer.php';
?>