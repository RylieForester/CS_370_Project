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

                //second report
                $con = @mysqli_connect("host", "username", "password", "database");
                //retrieve data
                $sql2 = "SELECT c.Category_name, i.Item_name, r.Review_text
                    FROM categories c
                    INNER JOIN items i 
                        ON c.Category_ID = i.Category_ID
                    LEFT OUTER JOIN reviews r 
                        ON i.Item_Number = r.Item_Number";
                $result2 = mysqli_query($con, $sql2);

                // Display the report
                echo '<table>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Category Name</th>';
                echo '<th>Item Name</th>';
                echo '<th>Review Text</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ($row = mysqli_fetch_assoc($result2))
                {
                    echo '<tr>';
                    echo '<td>' . $row['Category_name'] . '</td>';
                    echo '<td>' . $row['Item_name'] . '</td>';
                    echo '<td>' . $row['Review_text'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';

                //third report
                $sql3 = "SELECT c.First_name, c.Last_name, ca.Cart_id, p.Payment_type
                        FROM customers c
                        LEFT OUTER JOIN carts ca 
                            ON c.Customer_ID = ca.Customer_ID
                        LEFT OUTER JOIN payment_methods p 
                            ON ca.Customer_ID = p.Customer_ID";
                $result3 = mysqli_query($con, $sql3);

                //Display report
                echo '<table>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Customer Name</th>';
                echo '<th>Cart ID</th>';
                echo '<th>Payment Method Name</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ($row = mysqli_fetch_assoc($result3)) {
                    echo '<tr>';
                    echo '<td>' . $row['customer_name'] . '</td>';
                    echo '<td>' . $row['cart_id'] . '</td>';
                    echo '<td>' . $row['payment_method_name'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';


            }
        }
    ?>

</body>
</html>