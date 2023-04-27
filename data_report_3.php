<?php
$connection_error = false;
$connection_error_msg = "";

$con = @mysqli_connect("127.0.0.1", "test_user", "password", "mydb");

if(mysqli_connect_errno()){
    $connection_error = true;
    $connection_error_msg = "Failed ot connect to MySQL: ". mysqli_connect_error();
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
        output_error("Database connection failure!", $connection_error_msg);
    } else {
        function output_table_open() //the very top row of cells in the table
        {
            echo "<table class = 'table table-striped'>\n";
            echo "<thead><tr class = 'dataHeaderRow'>\n";
            echo "  <td>Order No.</td>\n";
            echo "  <td>Customer ID</td>\n";
            echo "  <td>Order Detail ID</td>\n";
            echo "  <td>Shipping Address</td>";
            echo "  <td>Billing Address</td>";
            echo "  <td>Est. Delivery Date</td>";
            echo "  <td>Item No.</td>";
            echo "  <td>Cost</td>";
            echo "  <td>Quantity</td>";
            echo "  <td>Amount</td>";
            echo "  <td>Payment_no.</td>";
            echo "</tr></thead>\n";
        }

        function output_table_close()
        {
            echo "</table>\n";
        }

        function output_detail_row($order_ID, $customer_ID, $order_detail_ID, $shipping_addr, $billing_addr, $est_delivery, $item_no, $cost, $quantity, $amount, $payment_no)
        {
            echo "<tr>\n";
            echo "<td>" . $order_ID . "</td>";
            echo "<td>" . $customer_ID . "</td>";
            echo "<td>" . $order_detail_ID . "</td>";
            echo "<td>" . $shipping_addr . "</td>";
            echo "<td>" . $billing_addr . "</td>";
            echo "<td>" . $est_delivery . "</td>";
            echo "<td>" . $item_no . "</td>";
            echo "<td>" . $cost . "</td>";
            echo "<td>" . $quantity . "</td>";
            echo "<td>" . $amount . "</td>";
            echo "<td>" . $payment_no . "</td>";
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
            $last_row = false;
            while($row = $result->fetch_array()){
                if($last_row != $row["Order_ID"]){
                    output_detail_row($row["Order_ID"],$row["Customer_ID"], $row["Order Detail_ID"], $row["Shipping_Addr"], $row["Billing_Addr"], $row["Est_Delivery_Date"], $row["Item_Number"], $row["Cost"],
                                            $row["Quantity_of_Item"], $row["Amount"], $row["Payment_no"]);
                }
            }

            output_table_close();
        }

    }
    ?>

<?php include_once ("footer.php") ?>
