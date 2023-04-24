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
                $Category_ID = $parsed_csv_line[0];
                $Category_Desc = $parsed_csv_line[1];
                $Category_type = $parsed_csv_line[2];
                $Item_Number = $parsed_csv_line[3];
                $Item_Name = $parsed_csv_line[4];
                $Price = $parsed_csv_line[5];
                $Total_in_Stock = $parsed_csv_line[6];
                $Item_Description = $parsed_csv_line[7];
                $Manufacturer = $parsed_csv_line[8];
                $Customer_ID = $parsed_csv_line[9];
                $Rating = $parsed_csv_line[10];
                $User_Comments = $parsed_csv_line[11];

                $mysql_First_Insert = "INSERT INTO mydb.Categories(Category_ID, Category_Desc, Category_type) 
                                    VALUES (" . $Category_ID . " , '" . $Category_Desc . "', '" . $Category_type . "');";

                $mysql_Second_Insert = "INSERT INTO mydb.Items(Item_Number, Item_Name, Price, Total_in_Stock, Category_ID, Item_Description, Manufacturer)
                                    VALUES (" . $Item_Number . " , '" . $Item_Name . "', '" . $Price . "', '" . $Total_in_Stock . "', '" . $Category_ID . "', '" . $Item_Description . "', '" . $Manufacturer . "');";

                $mysql_Third_Insert = "INSERT INTO mydb.Reviews(Customer_ID, Item_Number, Rating, User_Comments)
                                    VALUES (" . $Customer_ID . " , '" . $Item_Number . "', '" . $Rating . "', '" . $User_Comments . "');";

                $mysql_First_Update = "UPDATE mydb.categories
                                        SET
                                        Category_ID = '"  . $Category_ID . "',   
                                        Category_Desc = '" . $Category_Desc . "', 
                                        Category_type = '" . $Category_type . "'
                                        WHERE Category_ID = '" . $Category_ID . "'";

                $mysql_Second_Update = "UPDATE mydb.items
                                        SET
                                        Item_Number = '" . $Item_Number . "',
                                        Item_Name = '" . $Item_Name . "',
                                        Price = '" . $Price . "',
                                        Total_in_Stock = '" . $Total_in_Stock . "',
                                        Category_ID = '" . $Category_ID . "',
                                        Item_Description = '" . $Item_Description . "',
                                        Manufacturer = '" . $Manufacturer . "'
                                        WHERE Item_Number = '" . $Item_Number . "'";

                if ($count > 0) {

                    $sql_Category_Select = "SELECT categories.Category_Desc
                                        FROM mydb.categories
                                        WHERE Category_Desc = '" . $Category_Desc . "'";
                    $Cat_Select_result = mysqli_query($connection, $sql_Category_Select);
                    $Cat_row_count = mysqli_num_rows($Cat_Select_result);

                    if ($Category_Desc != $prev_Category_Desc) {
                        if ($Cat_row_count < 1) {
                            mysqli_query($connection, $mysql_First_Insert);
                            $count_of_Inserts++;
                        }else {
                            mysqli_query($connection, $mysql_First_Update);
                            $count_of_Updates++;
                        }
                    }

                    $sql_Items_Select = "SELECT Items.Item_Name
                                        FROM mydb.Items
                                        WHERE Item_Name = '" . $Item_Name . "'";
                    $Item_Select_result = mysqli_query($connection, $sql_Items_Select);
                    $Item_row_count = mysqli_num_rows($Item_Select_result);

                    if ($Item_Name != $prev_Item_name) {
                        if ($Item_row_count < 1) {
                            mysqli_query($connection, $mysql_Second_Insert);
                            $count_of_Inserts++;
                        } else {
                            mysqli_query($connection, $mysql_Second_Update);
                            $count_of_Updates++;
                        }
                    }

                    $sql_Review_Select = "SELECT Reviews.Customer_ID
                                        FROM mydb.Reviews
                                        WHERE Customer_ID = '" . $Customer_ID . "'";
                    $Review_Select_result = mysqli_query($connection, $sql_Review_Select);
                    $Review_row_count = mysqli_num_rows($Review_Select_result);

                        if ($Review_row_count < 1) {
                            mysqli_query($connection, $mysql_Third_Insert);
                            $count_of_Inserts++;
                        }

                }
                $count++;

                //For full credit, track how many rows were inserted and updated in each entity, and print them out.
                //TODO
                $prev_line = $line;
                $parsed_csv_line_2 = str_getcsv($prev_line);
                $prev_Category_Desc = $parsed_csv_line_2[1];
                $prev_Item_name = $parsed_csv_line_2[4];

                if ($line === $lines[array_key_last($lines)]) {
                    ?> <div class = "p-5 bg-dark"> <?php
                    $result = $connection->query("SELECT * FROM mydb.Categories");

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

                    $result2 = $connection->query("SELECT * FROM mydb.Items");

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

                    $result3 = $connection->query("SELECT * FROM mydb.Reviews");

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
            mysqli_close($connection);
            $import_succeeded = true;
        }
        catch(Error $exception){
            $import_error_message = $exception->getMessage()
                . " at: " . $exception->getFile()
                . " line: " . $exception->getLine() . " <br/>";

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
        <p class = "text-light" style="text-align: center"> Input the CSV file below for importing the Categories, Items, and Reviews.</p>
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



