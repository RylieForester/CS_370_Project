<?php //this program is for Data Report 1
$connection_error = false;
$connection_error_msg = "";

$con = @mysqli_connect("host", "username", "password", "database");

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
     table.customerDataTable {
            border-collapse: collapse;
            width: 100%;
        }
        table.customerDataTable td, table.customerDataTable th {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        table.customerDataTable th {
            background-color: #ddd;
        }
</style>

<body>
    <h1>Customer Data Report</h1>

    <?php
        if($connection_error){
            output_error("database connection failure!", $connection_error_msg);
        } else { //format the tables here
            function output_table_open(){
                echo "<table class = 'customerDataTable'>";
                echo "<tr><th>Customer ID</th><th>Name</th><th>Email</th></tr>";

                $sql = "SELECT * FROM customers";
            }
        }
    ?>

</body>

</html>