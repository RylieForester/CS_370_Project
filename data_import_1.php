<?php include_once("header.php") ?>

<?php

$import_attempted = false;
$import_succeeded = false;
$import_error_message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $import_attempted = true;

    $connection = @mysqli_connect("localhost", "data_import", "amazon", "mydb");

    if(mysqli_connect_errno()){
        $import_error_message = "Failed to connect to MySQL: ". mysqli_connect_error();
    }
    else{
        try{

            $contents = file_get_contents($_FILES["importFile"]["tmp_name"]);
            $lines = explode( "\n", $contents);
            $count = 0;
            $count_of_Inserts = 0;
            $count_of_Updates = 0;

            foreach($lines as $line){

                $parsed_csv_line = str_getcsv($line);

                //Do something with the parsed data . Look at the array (skip the first line).
                $Order_ID = $parsed_csv_line[0];
                $Shipping_Addr = $parsed_csv_line[1];
                $Billing_Addr = $parsed_csv_line[2];
                $Est_Delivery_Date = $parsed_csv_line[3];
                $Customer_ID = $parsed_csv_line[4];
                $Order_Detail_ID = $parsed_csv_line[5];
                $Quantity_of_Item = $parsed_csv_line[6];
                $Cost = $parsed_csv_line[7];
                $Total_Amount = $parsed_csv_line[8];
                $Item_Number = $parsed_csv_line[9];
                $Amount = $parsed_csv_line[10];

                $mysql_First_Insert = "INSERT INTO mydb.Order(Order_ID, Shipping_Addr, Billing_Addr, Est_Delivery_Date, Customer_ID) 
                                    VALUES (" . $Order_ID . " , '" . $Shipping_Addr . "', '" . $Billing_Addr . "','" . $Est_Delivery_Date . "','" . $Customer_ID . "');";

                $mysql_Second_Insert = "INSERT INTO mydb.Order_Detail(Order_Detail_ID, Order_ID, Quantity_of_Item, Cost, Total_Amount, Item_Number)
                                    VALUES (" . $Order_Detail_ID . " , '" . $Order_ID . "', '" . $Quantity_of_Item . "', '" . $Cost . "', '" . $Total_Amount . "', '" . $Item_Number . "');";

                $mysql_Third_Insert = "INSERT INTO mydb.Order_Payment(Order_ID, Customer_ID, Amount)
                                    VALUES (" . $Order_ID . " , '" . $Customer_ID . "', '" . $Amount . "');";

                $mysql_First_Update = "UPDATE mydb.Order
                                        SET
                                        Order_ID = '"  . $Order_ID . "',   
                                        Shipping_Addr = '" . $Shipping_Addr . "', 
                                        Billing_Addr = '" . $Billing_Addr . "',
                                        Est_Delivery_Date = '" . $Est_Delivery_Date . "',
                                        Customer_ID = '" . $Customer_ID . "'
                                        WHERE Order_ID = '" . $Order_ID . "'";

                $mysql_Second_Update = "UPDATE mydb.Order_Detail
                                        SET
                                        Order_Detail_ID = '"  . $Order_Detail_ID . "',   
                                        Order_ID = '" . $Order_ID . "', 
                                        Quantity_of_Item = '" . $Quantity_of_Item . "',
                                        Cost = '" . $Cost . "',
                                        Total_Amount = '" . $Total_Amount . "',
                                        Item_Number = '" . $Item_Number . "'
                                        WHERE Order_Detail_ID = '" . $Order_Detail_ID . "'";

                if ($count > 0) {

                    $sql_Order_Select = "SELECT Order.Shipping_Addr
                                        FROM mydb.Order
                                        WHERE Shipping_Addr = '" . $Shipping_Addr . "'";
                    $Order_Select_result = mysqli_query($connection, $sql_Order_Select);
                    $Order_row_count = mysqli_num_rows($Order_Select_result);

                    if ($Shipping_Addr != $prev_Shipping_Addr) {
                        if ($Order_row_count < 1) {
                            mysqli_query($connection, $mysql_First_Insert);
                            $count_of_Inserts++;
                        }else {
                            mysqli_query($connection, $mysql_First_Update);
                            $count_of_Updates++;
                        }
                    }

                    $sql_Order_Det_Select = "SELECT Order_Detail.Order_Detail_ID
                                        FROM mydb.Order_Detail
                                        WHERE Order_Detail_ID = '" . $Order_Detail_ID . "'";
                    $Order_Det_Select_result = mysqli_query($connection, $sql_Order_Det_Select);
                    $Order_Detail_row_count = mysqli_num_rows($Order_Det_Select_result);

                    if ($Order_Detail_ID != $prev_Order_Detail_ID) {
                        if ($Order_Detail_row_count < 1) {
                            mysqli_query($connection, $mysql_Second_Insert);
                            $count_of_Inserts++;
                        }else {
                            mysqli_query($connection, $mysql_Second_Update);
                            $count_of_Updates++;
                        }
                    }

                    $sql_Order_Pay_Select = "SELECT Order_payment.Order_ID
                                        FROM mydb.Order_payment
                                        WHERE Order_ID = '" . $Order_ID . "'";
                    $Order_Pay_Select_result = mysqli_query($connection, $sql_Order_Pay_Select);
                    $Order_Pay_row_count = mysqli_num_rows($Order_Pay_Select_result);

                    if ($Order_ID != $prev_Order_ID) {
                        if ($Order_Pay_row_count < 1) {
                            mysqli_query($connection, $mysql_Third_Insert);
                            $count_of_Inserts++;
                        }
                    }
                    
                }
                $count++;

                //For full credit, track how many rows were inserted and updated in each entity, and print them out.
                //TODO
                $prev_line = $line;
                $parsed_csv_line_2 = str_getcsv($prev_line);
                $prev_Shipping_Addr = $parsed_csv_line_2[1];
                $prev_Order_Detail_ID = $parsed_csv_line_2[5];
                $prev_Order_ID = $parsed_csv_line_2[0];

            }

            $connection->close();
            $import_succeeded = true;

        }
        catch(Error $exception){
            $import_error_message = $exception->getMessage()
                . " at: " . $exception->getFile()
                . " line:  " . $exception->getLine() . " <br/>";

        }
    }
}
?>

<html lang="en">

<head>
    <title>Data Import Group 1</title>
</head>

<body>
<div class = "p-5 bg-dark">
    <?php
    if($import_attempted){
        if($import_succeeded){
            ?>
            <h1><span class="text-success">Import Succeeded!</span></h1>

            <?php
        } else{?>
            <h1><span class="text-danger">Import Failed!</span></h1>
            <span class="text-danger"><?php  echo $import_error_message; ?> </span>

            <?php
        }
    }?>
</div>

<div class="p-5 bg-dark">

    <h1 class = "text-light" style="text-align: center; text-decoration: underline">Group 1 Data Import</h1>
    <br>
    <p class = "text-light" style="text-align: center"> Input the CSV file below for importing the Order, Order Detail, & Order Payment.</p>
    <br>
    <form method = "post" enctype = "multipart/form-data" style="text-align: center">
        <p style="text-align:center">Select CSV to upload:</p>
        <input class="form-control" type="file" name="importFile" style="text-align:center">
        <input class="btn btn-primary" type = "submit" value = "Upload Data" />
    </form>
</div>

</body>

</html>

<?php include_once("footer.php")?>



