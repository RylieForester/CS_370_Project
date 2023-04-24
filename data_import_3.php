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

                if ($count > 0) {

                    $sql_Customer_Select = "SELECT Customer.Customer_ID
                                        FROM mydb.Customer
                                        WHERE Customer_ID = '" . $Customer_ID . "'";
                    $Customer_Select_result = mysqli_query($connection, $sql_Customer_Select);
                    $Customer_row_count = mysqli_num_rows($Customer_Select_result);

                    if ($Customer_ID != $prev_Customer_ID) {
                        if ($Customer_row_count < 1) {
                            mysqli_query($connection, $mysql_First_Insert);
                            $count_of_Inserts++;
                        }else {
                            mysqli_query($connection, $mysql_First_Update);
                            $count_of_Updates++;
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
                            $count_of_Inserts++;
                        }else {
                            mysqli_query($connection, $mysql_Second_Update);
                            $count_of_Updates++;
                        }
                    }

                    $sql_Pay_Select = "SELECT Payment_Methods.Customer_ID
                                        FROM mydb.Payment_Methods
                                        WHERE Customer_ID = '" . $Customer_ID . "'";
                    $Pay_Select_result = mysqli_query($connection, $sql_Pay_Select);
                    $Pay_row_count = mysqli_num_rows($Pay_Select_result);

                    if ($Customer_ID != $prev_Customer_ID) {
                        if ($Pay_row_count < 1) {
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
                $prev_Customer_ID = $parsed_csv_line_2[0];
                $prev_Order_Detail_ID = $parsed_csv_line_2[5];

                if ($line === $lines[array_key_last($lines)]) {

                    ?><div class = "p-5 bg-dark"> <?php

                    $result = $connection->query("SELECT * FROM mydb.Customer");

                    $query = array();
                    while($query[] = mysqli_fetch_assoc($result));
                    array_pop($query);

                    echo '<table border="1">';
                    echo '<tr>';
                    foreach($query[0] as $key => $value) {
                        echo '<td>';
                        echo $key;
                        echo '</td>';
                    }
                    echo '</tr>';
                    foreach($query as $row) {
                        echo '<tr>';
                        foreach($row as $column) {
                            echo '<td>';
                            echo $column;
                            echo '</td>';
                        }
                        echo '</tr>';
                    }
                    echo '</table>';

                    $result2 = $connection->query("SELECT * FROM mydb.Cart");

                    $query2 = array();
                    while($query2[] = mysqli_fetch_assoc($result2));
                    array_pop($query2);

                    echo '<table border="1">';
                    echo '<tr>';
                    foreach($query2[0] as $key => $value) {
                        echo '<td>';
                        echo $key;
                        echo '</td>';
                    }
                    echo '</tr>';
                    foreach($query2 as $row) {
                        echo '<tr>';
                        foreach($row as $column) {
                            echo '<td>';
                            echo $column;
                            echo '</td>';
                        }
                        echo '</tr>';
                    }
                    echo '</table>';

                    $result3 = $connection->query("SELECT * FROM mydb.Payment_Methods");

                    $query3 = array();
                    while($query3[] = mysqli_fetch_assoc($result3));
                    array_pop($query3);

                    echo '<table border="1">';
                    echo '<tr>';
                    foreach($query3[0] as $key => $value) {
                        echo '<td>';
                        echo $key;
                        echo '</td>';
                    }
                    echo '</tr>';
                    foreach($query3 as $row) {
                        echo '<tr>';
                        foreach($row as $column) {
                            echo '<td>';
                            echo $column;
                            echo '</td>';
                        }
                        echo '</tr>';
                    }
                    echo '</table>';

                    echo "There were " . $count_of_Inserts . " rows inserted and " . $count_of_Updates . " rows updated";
    ?> </div> <?php
                }

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
    <title>Data Import Group 3</title>
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

    <h1 class = "text-light" style="text-align: center; text-decoration: underline">Group 3 Data Import</h1>
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




