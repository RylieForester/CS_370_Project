<?php
$connection_error = false;
$connection_error_message = "";

$con = @mysqli_connect("127.0.0.1", "CS370Project", "amazon", "mydb");

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
        font-size: 18px;
        width: 100px;
        border-right: 6px solid white;
        border-left: 6px solid white;
    }

    #customerInfo{
        font-size: 16px;
        text-align: left;
        border-right: 6px solid white;
        border-left: 6px solid white;
        border-bottom: 6px solid white;
    }

    #dataInfo{
        font-size: 16px;
        text-align: left;
        border-right: 6px solid white;
        border-left: 6px solid white;
        border-bottom: 6px solid white;
    }

</style>

<div class="p-5 bg-dark">

    <h1 class="text-light" style="text-align: center; text-decoration: underline">Customer, Cart, and Payment Methods Data Report</h1>
    <br>
    <p class = "text-light" style="text-align: center"> Below is the report from Import Data 2, which inserted and/or updated data belonging in
        the <span style="color: rgb(94, 152, 203)">Customer</span>, <span style="color: rgb(95, 102, 173)">Cart</span>, and
        <span style="color: rgb(140, 85, 151)">Payment Methods</span> tables in our database.</p>
    <br>


    <?php
    if($connection_error){
        output_error("Database connection failure!", $connection_error_message);
    }
    else{
        function output_table_open(){
            echo "<table class = 'table table-striped'>\n";
            echo "<thead><tr style='background-color: rgb(94, 152, 203); border-top: 6px solid white;'>\n";
            echo "  <td id = 'headers'>Customer ID</td>\n";
            echo "  <td id = 'headers'>First Name</td>\n";
            echo "  <td id = 'headers'>Last Name</td>\n";
            echo "  <td id = 'headers'>Age</td>\n";
            echo "  <td id = 'headers'>Preferred Gender</td>\n";
            echo "  <td id = 'headers'>Phone Number</td>\n";
            echo "  <td id = 'headers'>Address</td>\n";
            echo "  <td id = 'headers'>Email</td>\n";
            echo "  <td id = 'headers'>Username</td>\n";
            echo "  <td id = 'headers'>Password</td>\n";
            echo "</tr></thead>\n";
        }

        function output_table_close(){
            echo "</table>\n";
        }

        function output_customer_row($customer_id, $first_name, $last_name, $age, $gender, $phone_number, $address, $email, $username, $password)
        {
            echo "<tr style='background-color: rgb(94, 152, 203);'>\n";
            echo "  <td id = 'customerInfo'>" . $customer_id   . "</td>\n";
            echo "  <td id = 'customerInfo'>" . $first_name    . "</td>\n";
            echo "  <td id = 'customerInfo'>" . $last_name . "</td>\n";
            echo "  <td id = 'customerInfo'>" . $age . "</td>\n";
            echo "  <td id = 'customerInfo'>" . $gender . "</td>\n";
            echo "  <td id = 'customerInfo'>" . $phone_number . "</td>\n";
            echo "  <td id = 'customerInfo'>" . $address . "</td>\n";
            echo "  <td id = 'customerInfo'>" . $email . "</td>\n";
            echo "  <td id = 'customerInfo'>" . $username . "</td>\n";
            echo "  <td id = 'customerInfo'>" . $password . "</td>\n";
            echo "</tr>\n";
        }

        function output_cart_row($item_number, $quantity){

            echo "<tr style='background-color: rgb(95, 102, 173)'>\n";
            echo "  <td id = 'headers' colspan='5'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Item Number</td>\n";
            echo "  <td id = 'headers' colspan='5'>Quantity</td>\n";
            echo "</tr>\n";

            echo "<tr style='background-color: rgb(95, 102, 173)'>\n";
            echo "  <td id = 'dataInfo' style='text-align: left' colspan='5'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $item_number   . "</td>\n";
            echo "  <td id = 'dataInfo' colspan='5'>" . $quantity   . "</td>\n";
            echo "</tr>\n";
        }

        function output_payment_row($payment_type, $card_number){
            echo "<tr style='background-color: rgb(140, 85, 151)'>\n";
            echo "  <td id = 'headers' colspan='5'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Payment Type</td>\n";
            echo "  <td id = 'headers' colspan='5'>Card Number</td>\n";
            echo "</tr>\n";

            echo "<tr style='background-color: rgb(140, 85, 151)'>\n";
            echo "  <td id = 'dataInfo' style='text-align: left' colspan='5'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $payment_type   . "</td>\n";
            echo "  <td id = 'dataInfo' colspan='5'>" . $card_number    . "</td>\n";
            echo "</tr>\n";
        }

        $query = "SELECT t0.*, t1.Item_number, t1.Quantity_of_Item, t2.Payment_type, t2.Card_number"
            ." FROM mydb.Customer t0"
            ." LEFT OUTER JOIN mydb.Cart t1 ON t0.Customer_ID = t1.Customer_ID"
            ." LEFT OUTER JOIN mydb.Payment_Methods t2 ON t0.Customer_ID = t2.Customer_ID"
            ." ORDER BY t0.Customer_ID, t1.Item_number, t2.Payment_type";

        $result = mysqli_query($con, $query);

        if(! $result){
            if(mysqli_errno($con)){
                output_error("Data retrieval failure!", mysqli_error($con));
            }
            else{
                echo "No data found!";
            }
        }
        else{
            //Open table.
            output_table_open();

            $last_customer = null;
            $last_cart = null;
            $last_payment = null;

            while($row = $result->fetch_array()){

                if($last_customer != $row["Customer_ID"]){

                    //Output category row.
                    output_customer_row($row["Customer_ID"], $row["First_name"], $row["Last_name"], $row["Age"], $row["Pref_gender"], $row["Phone_number"], $row["Address"], $row["Email"], $row["Username"], $row["Password"]);
                }

                if($last_cart != $row["Item_number"]){

                    //Output item row.
                    output_cart_row($row["Item_number"], $row["Quantity_of_Item"]);

                }

                if($last_payment != $row["Customer_ID"]){

                    //Output review row.
                    output_payment_row($row["Payment_type"], $row["Card_number"]);

                }

                $last_customer = $row["Customer_ID"];
                $last_cart = $row["Item_number"];
                $last_payment = $row["Customer_ID"];

            }
            //Close table.
            output_table_close();
        }
    }

    ?>
</div>
<?php include_once("footer.php") ?>
