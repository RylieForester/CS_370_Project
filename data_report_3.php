<?php
$connection_error = false;
$connection_error_msg = "";

$con = @mysqli_connect("127.0.0.1", "CS370Project", "amazon", "mydb");

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
<style>
    table{
        margin-left: auto;
        margin-right: auto;
    }

    td{
        font-size: 18px;
        text-align: left;
        width: 50px;
        height: 45px;
    }

    #headers{
        font-weight: bold;
        font-size: 16px;
        width: 100px;
        border-right: 6px solid white;
        border-left: 6px solid white;
    }

    #orderInfo{
        font-size: 16px;
        text-align: left;
        border-right: 6px solid white;
        border-left: 6px solid white;
        border-bottom: 6px solid white;
    }

    #dataInfo{
        font-size: 20px;
        text-align: left;
        border-right: 6px solid white;
        border-left: 6px solid white;
        border-bottom: 6px solid white;
    }

</style>

<div class="p-5 bg-dark">

    <h1 class="text-light" style="text-align: center; text-decoration: underline">Order, Order Detail, and Order Payment Data Report</h1>
    <br>
    <p class = "text-light" style="text-align: center"> Below is the report from Import Data 3, which inserted and/or updated data belonging in
        the <span style="color: rgb(94, 152, 203)">Order</span>, <span style="color: rgb(95, 102, 173)">Order Detail</span>, and
        <span style="color: rgb(140, 85, 151)">Order Payment</span> tables in our database.</p>
    <br>

<?php
if($connection_error){
    output_error("Database connection failure!", $connection_error_msg);
} else {
    function output_table_open() //the very top row of cells in the table
    {
        echo "<table class = 'table table-striped'>\n";
        echo "<thead><tr style='background-color: rgb(94, 152, 203); border-top: 6px solid white;'>\n";
        echo "  <td id = 'headers'>Order ID</td>\n";
        echo "  <td id = 'headers'>Customer ID</td>\n";
        echo "  <td id = 'headers'>Shipping Address</td>";
        echo "  <td id = 'headers'>Billing Address</td>";
        echo "  <td id = 'headers'>Est. Delivery Date</td>";
        echo "</tr></thead>\n";
    }

    function output_table_close()
    {
        echo "</table>\n";
    }

    function output_order_row($order_id, $customer_id, $shipping_addr, $billing_addr, $est_date)
    {
        echo "<tr style='background-color: rgb(94, 152, 203);'>\n";
        echo "  <td id = 'orderInfo'>" . $order_id   . "</td>\n";
        echo "  <td id = 'orderInfo'>" . $customer_id . "</td>\n";
        echo "  <td id = 'orderInfo'>" . $shipping_addr    . "</td>\n";
        echo "  <td id = 'orderInfo'>" . $billing_addr . "</td>\n";
        echo "  <td id = 'orderInfo'>" . $est_date . "</td>\n";
        echo "</tr>\n";
    }

    function output_order_detail_row($order_detail_id, $item_number, $quantity, $cost){

        echo "<tr style='background-color: rgb(95, 102, 173)'>\n";
        echo "  <td id = 'headers'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Order Detail ID</td>\n";
        echo "  <td id = 'headers'>Item Number</td>\n";
        echo "  <td id = 'headers'>Quantity of Item</td>\n";
        echo "  <td id = 'headers' colspan='2'>Cost</td>\n";
        echo "</tr>\n";

        echo "<tr style='background-color: rgb(95, 102, 173)'>\n";
        echo "  <td id = 'dataInfo' style='text-align: left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $order_detail_id   . "</td>\n";
        echo "  <td id = 'dataInfo'>" . $item_number . "</td>\n";
        echo "  <td id = 'dataInfo'>" . $quantity . "</td>\n";
        echo "  <td id = 'dataInfo' colspan='2'>" . $cost . "</td>\n";
        echo "</tr>\n";
    }

    function output_order_payment_row($payment_number, $amount){
        echo "<tr style='background-color: rgb(140, 85, 151)'>\n";
        echo "  <td id = 'headers' colspan='3'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Payment Number</td>\n";
        echo "  <td id = 'headers' colspan='2'>Amount</td>\n";
        echo "</tr>\n";

        echo "<tr style='background-color: rgb(140, 85, 151)'>\n";
        echo "  <td id = 'dataInfo' style='text-align: left' colspan='3'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $payment_number   . "</td>\n";
        echo "  <td id = 'dataInfo' colspan='2'>" . $amount    . "</td>\n";
        echo "</tr>\n";
    }

    $query = "SELECT t0.Order_ID, t0.Shipping_Addr, t0.Billing_Addr, t0.Est_Delivery_Date, t1.Order_Detail_ID, t1.Item_Number, t1.Quantity_of_Item, t1.Cost, t2.Customer_ID, t2.Amount, t2.Payment_no" .
        " FROM mydb.Order t0" .
        " INNER JOIN mydb.Order_Detail t1 ON t0.Order_ID = t1.Order_ID" .
        " LEFT OUTER JOIN mydb.Order_Payment t2 ON t0.Order_ID = t2.Order_ID" .
        " ORDER BY t0.Order_ID, t1.Order_Detail_ID, t2.Payment_no";

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
        $last_order = null;
        $last_order_detail = null;
        $last_order_payment = null;

        while($row = $result->fetch_array()){
            if($last_order != $row["Order_ID"]){

                //Output order row.
                output_order_row($row["Order_ID"], $row["Customer_ID"], $row["Shipping_Addr"], $row["Billing_Addr"], $row["Est_Delivery_Date"]);
            }

            if($last_order_detail != $row["Order_Detail_ID"]){

                //Output order detail row.
                output_order_detail_row($row["Order_Detail_ID"], $row["Item_Number"], $row["Quantity_of_Item"], $row["Cost"]);

            }

            if($last_order_payment != $row["Order_ID"]){

                //Output order payment row.
                output_order_payment_row($row["Payment_no"], $row["Amount"]);

            }

            $last_order = $row["Order_ID"];
            $last_order_detail = $row["Order_Detail_ID"];
            $last_order_payment = $row["Order_ID"];

        }
        //Closes table.
        output_table_close();
    }
}

?>
</div>

<?php include_once ("footer.php") ?>
