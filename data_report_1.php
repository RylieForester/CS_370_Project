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

    #categoryInfo{
        font-size: 16px;
        text-align: left;
        border-right: 6px solid white;
        border-left: 6px solid white;
        border-bottom: 6px solid white;
    }

    #dataInfo{
        font-size: 16px;
        text-align: center;
        border-right: 6px solid white;
        border-left: 6px solid white;
        border-bottom: 6px solid white;
    }

</style>

<div class="p-5 bg-dark">

<h1 class="text-light" style="text-align: center; text-decoration: underline">Categories, Items, and Reviews Data Report</h1>
<br>
<p class = "text-light" style="text-align: center"> Below is the report from Import Data 1, which inserted and/or updated data belonging in
    the <span style="color: rgb(94, 152, 203)">Categories</span>, <span style="color: rgb(95, 102, 173)">Items</span>, and
    <span style="color: rgb(140, 85, 151)">Reviews</span> tables in our database.</p>
<br>


<?php
if($connection_error){
    output_error("Database connection failure!", $connection_error_message);
}
else{
    function output_table_open(){
        echo "<table class = 'table table-striped'>\n";
        echo "<thead><tr style='background-color: rgb(94, 152, 203); border-top: 6px solid white;'>\n";
        echo "  <td id = 'headers' colspan='2'>Category ID</td>\n";
        echo "  <td id = 'headers' colspan='2'>Category Description</td>\n";
        echo "  <td id = 'headers' colspan='2'>Category Type</td>\n";
        echo "</tr></thead>\n";
    }

    function output_table_close(){
        echo "</table>\n";
    }

    function output_category_row($category_id, $category_desc, $category_type)
    {
        echo "<tr style='background-color: rgb(94, 152, 203);'>\n";
        echo "  <td id = 'categoryInfo' colspan='2'>" . $category_id   . "</td>\n";
        echo "  <td id = 'categoryInfo' colspan='2'>" . $category_desc    . "</td>\n";
        echo "  <td id = 'categoryInfo' colspan='2'>" . $category_type . "</td>\n";
        echo "</tr>\n";
    }

    function output_item_row($item_number, $item_name, $price, $total_stock, $item_desc, $manufacturer){

        echo "<tr style='background-color: rgb(95, 102, 173)'>\n";
        echo "  <td id = 'headers'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Item Number</td>\n";
        echo "  <td id = 'headers'>Item Name</td>\n";
        echo "  <td id = 'headers'>Price</td>\n";
        echo "  <td id = 'headers'>Total in Stock</td>\n";
        echo "  <td id = 'headers'>Item Description</td>\n";
        echo "  <td id = 'headers'>Manufacturer</td>\n";
        echo "</tr>\n";

        echo "<tr style='background-color: rgb(95, 102, 173)'>\n";
        echo "  <td id = 'dataInfo' style='text-align: left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $item_number   . "</td>\n";
        echo "  <td id = 'dataInfo'>" . $item_name    . "</td>\n";
        echo "  <td id = 'dataInfo'>" . $price . "</td>\n";
        echo "  <td id = 'dataInfo'>" . $total_stock . "</td>\n";
        echo "  <td id = 'dataInfo'>" . $item_desc . "</td>\n";
        echo "  <td id = 'dataInfo'>" . $manufacturer . "</td>\n";
        echo "</tr>\n";
    }

    function output_review_row($customer_id, $rating, $comment){
        echo "<tr style='background-color: rgb(140, 85, 151)'>\n";
        echo "  <td id = 'headers'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Customer_ID</td>\n";
        echo "  <td id = 'headers'>Rating</td>\n";
        echo "  <td id = 'headers' colspan='4'>User Comments</td>\n";
        echo "</tr>\n";

        echo "<tr style='background-color: rgb(140, 85, 151)'>\n";
        echo "  <td id = 'dataInfo' style='text-align: left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $customer_id   . "</td>\n";
        echo "  <td id = 'dataInfo'>" . $rating    . "</td>\n";
        echo "  <td id = 'dataInfo' style='text-align: left' colspan='4'>" . $comment . "</td>\n";
        echo "</tr>\n";
    }

    $query = " SELECT t0.*, t1.Item_number, t1.Item_name, t1.Price, t1.Total_in_Stock, t1.Item_description, t1.Manufacturer, t2.Customer_ID ,t2.Rating, t2.User_comments "
            ." FROM mydb.Categories t0"
            ." INNER JOIN mydb.Items t1 ON t0.Category_ID = t1.Category_ID"
            ." LEFT OUTER JOIN mydb.Reviews t2 ON t1.Item_number = t2.Item_number"
            ." ORDER BY t0.Category_ID, t1.Item_number, t2.Customer_ID";
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

        $last_category = null;
        $last_item = null;
        $last_review = null;

        while($row = $result->fetch_array()){

            if($last_category != $row["Category_ID"]){

                //Output category row.
                output_category_row($row["Category_ID"], $row["Category_Desc"], $row["Category_type"]);
            }

            if($last_item != $row["Item_number"]){

                //Output item row.
                output_item_row($row["Item_number"], $row["Item_name"], $row["Price"], $row["Total_in_Stock"], $row["Item_description"], $row["Manufacturer"]);

            }

            if($last_review != $row["Customer_ID"]){

                //Output review row.
                output_review_row($row["Customer_ID"], $row["Rating"], $row["User_comments"]);

            }

            $last_category = $row["Category_ID"];
            $last_item = $row["Item_number"];
            $last_review = $row["Customer_ID"];

        }
        //Close table.
        output_table_close();
    }
}

?>
</div>
<?php include_once("footer.php") ?>
