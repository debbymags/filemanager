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

    <script>
        //function to search list of public files
        function myFunction() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("publicTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
        //function to search list of private files
        function myFunction2() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput2");
            filter = input.value.toUpperCase();
            table = document.getElementById("privateTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

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