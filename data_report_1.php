<?php
$connection_error = false;
$connection_error_msg = "";

$con = @mysqli_connect("localhost", "username", "password", "database");

if(mysqli_connect_errno()){
    $connection_error = true;
    $connection_error_message = "Failed ot connect to MySQL: ". mysqli_connect_error();
}

function output_error($title, $error){
    echo "<span style='color: red;'>\n";
    echo "<h2>" . $title . "</h2>\n";
    echo "<h4>" . $error . "</h4>\n";
    echo "<span>";
}
?>

<?php include_once("header.php") ?>
    <h1>Customer Data Report</h1>

    <?php
    if($connection_error){
        output_error("Database connection failure!", $connection_error_message);
    } else {
        function output_table_open()
        {
            echo "<table class = 'table table-striped'>\n";
            echo "<thead><tr class = 'dataHeaderRow'>\n";
            echo "  <td>Order</td>\n";
            echo "  <td>Order Detail</td>\n";
            echo "  <td>Order Payment</td>\n";
            echo "</tr></thead>\n";
        }

        function output_table_close()
        {
            echo "</table>\n";
        }

        function output_row($order, $orderDetail, $orderPayment)
        {
            echo "<tr class = 'pizzaDataRow'>\n";
            echo "  <td>" . $order . "</td>\n";
            echo "  <td>" . $orderDetail . "</td>\n";
            echo "  <td>" . $orderPayment . "</td>\n";
            echo "</tr>\n";
        }

        function output_detail_row($quantity, $cost, $itemNo, $detailID)
        {
            echo "<tr>\n";
            echo "  <td colspan='3' class = 'dataDetailsCell'>\n";
            echo "      Quantity: " . $quantity . "<br/>\n";
            echo "      Subtotal: " . $cost . "<br/>\n";
            echo "      Item No: " . $itemNo . "<br/>\n";
            echo "      Order Detail: " . $detailID . "<br/>\n";
            echo "  </td>\n";
            echo "</tr>\n";
        }

        $query = "SELECT t0.Order_ID, t0.Shipping_addr, t0.Billing_addr, t0.Est_Delivery_date, 
                        t1.Order_Detail_ID, t1.Item_number, t1.Quantity_of_item, t1.Cost, 
                        t2.Customer_ID, t2.Amount, t2.Payment_no" .
                 "FROM mydb.Order t0" .
                 "INNER JOIN mydb.Order_detail t1 ON t0.Order_ID = t1.Order_ID" .
                 "LEFT OUTER JOIN mydb.order_payment t2 ON t2.Order_ID = t1.Order_ID";
        $result = mysqli_query($con, $query);

        if(! $result){
            if(mysqli_errno($con)){
                output_error("Data retrieval failure!", mysqli_error($con));
            }
            else{
                echo "No order data found!";
            }
        } else {
            //open table
            output_table_open();

            while($row = $result->fetch_array()){
                
            }
        }

    }
    ?>

<?php include_once ("footer.php") ?>
