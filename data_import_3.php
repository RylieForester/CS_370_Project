<?php include_once("header.php") ?>

<?php

$import_attempted = false;
$import_succeeded = false;
$import_error_message = "";

$count_of_Inserts_in_Customer = 0;
$count_of_Inserts_in_Cart = 0;
$count_of_Inserts_in_Pay = 0;
$count_of_Updates_in_Customer = 0;
$count_of_Updates_in_Cart = 0;
$count_of_Updates_in_Pay = 0;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $import_attempted = true;

    $connection = @mysqli_connect("localhost", "newuser", "mike", "mydb");

    if(mysqli_connect_errno()){
        $import_error_message = "Failed to connect to MySQL: ". mysqli_connect_error();
    }
    else{
        try{

            $contents = file_get_contents($_FILES["importFile"]["tmp_name"]);
            $lines = explode( "\n", $contents);
            $count = 0;

            foreach($lines as $line){

                $parsed_csv_line = str_getcsv($line);

                //TODO: Do something with the parsed data . Look at the array (skip the first line).
                $Customer_ID = $parsed_csv_line[0];
                $First_name = $parsed_csv_line[1];
                $Last_name = $parsed_csv_line[2];
                $Age = $parsed_csv_line[3];
                $Pref_gender = $parsed_csv_line[4];
                $Phone_number = $parsed_csv_line[5];
                $Address = $parsed_csv_line[6];
                $Email = $parsed_csv_line[7];
                $Username = $parsed_csv_line[8];
                $Password = $parsed_csv_line[9];
                $Item_Number = $parsed_csv_line[10];
                $Quantity_of_Item = $parsed_csv_line[11];
                $Payment_type = $parsed_csv_line[12];
                $Card_Number = $parsed_csv_line[13];

                $mysql_First_Insert = "INSERT INTO mydb.Customer(Customer_ID, First_name, Last_name, Age, Pref_gender, Phone_number, Address, Email, Username, Password) 
                                    VALUES (" . $Customer_ID . " , '" . $First_name . "', '" . $Last_name . "','" . $Age . "','" . $Pref_gender . "','" . $Phone_number . "','" . $Address . "','" . $Email . "','" . $Username . "','" . $Password . "');";

                $mysql_Second_Insert = "INSERT INTO mydb.Cart(Customer_ID, Item_Number, Quantity_of_Item)
                                    VALUES (" . $Customer_ID . " , '" . $Item_Number . "', '" . $Quantity_of_Item . "');";

                $mysql_Third_Insert = "INSERT INTO mydb.Payment_methods(Customer_ID, Payment_type, Email, Card_number)
                                    VALUES (" . $Customer_ID . ", '" . $Payment_type . "', '" . $Email . "','" . $Card_Number . "');";

                $mysql_First_Update = "UPDATE mydb.Customer
                                        SET
                                        Customer_ID = '"  . $Customer_ID . "',   
                                        First_name = '" . $First_name . "', 
                                        Last_name = '" . $Last_name . "',
                                        Age = '" . $Age . "',
                                        Pref_gender = '" . $Pref_gender . "',
                                        Phone_number = '" . $Phone_number . "',
                                        Address = '" . $Address . "',
                                        Email = '" . $Email . "',
                                        Username = '" . $Username . "',
                                        Password = '" . $Password . "'
                                        WHERE Customer_ID = '" . $Customer_ID . "'";

                $mysql_Second_Update = "UPDATE mydb.Cart
                                        SET
                                        Customer_ID = '"  . $Customer_ID . "',   
                                        Item_number = '" . $Item_Number . "', 
                                        Quantity_of_Item = '" . $Quantity_of_Item . "'
                                        WHERE Customer_ID = '" . $Customer_ID . "'";

                $mysql_Third_Update = "UPDATE mydb.Payment_methods
                                        SET
                                        Customer_ID = '"  . $Customer_ID . "',   
                                        Email = '" . $Email . "', 
                                        Payment_type = '" . $Payment_type . "',
                                        Card_Number = '" . $Card_Number . "'
                                        WHERE Customer_ID = '" . $Customer_ID . "'
                                        AND Card_number = '" . $Card_Number . "'";

                if ($count > 0) {

                    $sql_Customer_Select = "SELECT Customer.Customer_ID
                                        FROM mydb.Customer
                                        WHERE Customer_ID = '" . $Customer_ID . "'";
                    $Customer_Select_result = mysqli_query($connection, $sql_Customer_Select);
                    $Customer_row_count = mysqli_num_rows($Customer_Select_result);

                    if ($Customer_ID != $prev_Customer_ID) {
                        if ($Customer_row_count < 1) {
                            mysqli_query($connection, $mysql_First_Insert);
                            $count_of_Inserts_in_Customer++;
                        }else {
                            mysqli_query($connection, $mysql_First_Update);
                            $count_of_Updates_in_Customer++;
                        }
                    }

                    $sql_Cart_Select = "SELECT Cart.Customer_ID
                                        FROM mydb.Cart
                                        WHERE Customer_ID = '" . $Customer_ID . "'";
                    $Cart_Select_result = mysqli_query($connection, $sql_Cart_Select);
                    $Cart_row_count = mysqli_num_rows($Cart_Select_result);

                    if ($Customer_ID != $prev_Customer_ID) {
                        if ($Cart_row_count < 1) {
                            mysqli_query($connection, $mysql_Second_Insert);
                            $count_of_Inserts_in_Cart++;
                        }else {
                            mysqli_query($connection, $mysql_Second_Update);
                            $count_of_Updates_in_Cart++;
                        }
                    }

                    $sql_Pay_Select = "SELECT Payment_Methods.Customer_ID, Payment_methods.card_number
                                        FROM mydb.Payment_Methods
                                        WHERE Customer_ID = '" . $Customer_ID . "'
                                        AND Card_number = '" . $Card_Number . "'";
                    $Pay_Select_result = mysqli_query($connection, $sql_Pay_Select);
                    $Pay_row_count = mysqli_num_rows($Pay_Select_result);

                    if ($Customer_ID != $prev_Customer_ID || $Card_Number != $prev_Card_Number) {
                        if ($Pay_row_count < 1) {
                            mysqli_query($connection, $mysql_Third_Insert);
                            $count_of_Inserts_in_Pay++;
                        } else {
                            mysqli_query($connection, $mysql_Third_Update);
                            $count_of_Updates_in_Pay++;
                        }
                    }

                }
                $count++;

                //For full credit, track how many rows were inserted and updated in each entity, and print them out.
                $prev_line = $line;
                $parsed_csv_line_2 = str_getcsv($prev_line);
                $prev_Customer_ID = $parsed_csv_line_2[0];
                $prev_Order_Detail_ID = $parsed_csv_line_2[5];
                $prev_Card_Number = $parsed_csv_line_2[13];


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
    <title>Data Import Group 2</title>
</head>

<body>
<div class = "p-5 bg-dark">
    <?php
    if($import_attempted){
        if($import_succeeded){
            ?>
            <h1><span class="text-success">Import Succeeded!</span></h1>
            <?php echo "There were " . $count_of_Inserts_in_Customer . " rows inserted in Customer.\r\n";
            echo "There were " . $count_of_Updates_in_Customer . " rows updated in Customer.\r\n";
            ?> <br> <?php
            echo "There were " . $count_of_Inserts_in_Cart . " rows inserted in Cart.\r\n";
            echo "There were " . $count_of_Updates_in_Cart . " rows updated in Cart.\r\n";
            ?> <br> <?php
            echo "There were " . $count_of_Inserts_in_Pay . " rows inserted in Payment_Methods.\r\n";
            echo "There were " . $count_of_Updates_in_Pay . " rows updated in Payment_Methods.\r\n";
            ?>
            <?php
        } else{?>
            <h1><span class="text-danger">Import Failed!</span></h1>
            <span class="text-danger"><?php  echo $import_error_message; ?> </span>

            <?php
        }
    }?>
</div>

<div class="p-5 bg-dark">

    <h1 class = "text-light" style="text-align: center; text-decoration: underline">Group 2 Data Import</h1>
    <br>
    <p class = "text-light" style="text-align: center"> Input the CSV file below for importing the Customer, Cart, & Payment Methods.</p>
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




