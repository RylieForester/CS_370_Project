<?php
$connection_error = false;
$connection_error_msg = "";

$con = @mysqli_conect("host", "username", "password", "database");

if(mysqli_connect_errno()){
    $connection_error = true;
    $connection_error_msg = "Failed to connect to MySQL: " . mysqli_connect_error();
}

function output_error($title, $error){
    echo "<span style = 'color: red;'>\n";
    echo "<h2>" . $title . "</h2>\n";
    echo "<h4>" . $error . "</h4>\n";
    echo "</span>";
}
?>

<html>

<head>
    <title>Customer Data Report</title>
</head>
    
<style> /* add table formatting here*/
     
</style>

<body>
    <h1>Customer Data Report</h1>

    <?php
        if($connection_error){
            output_error("database connection failure!", $connection_error_msg);
        } else { //format the tables here
            function output_table_open(){
                echo "<table class = 'customerDataTable'>";
            }
        }
    ?>

</body>

</html>