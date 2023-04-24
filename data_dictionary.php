<?php include_once("header.php")?>

<style>
    table{
        border: 4px solid white;
        background-color: rgb(94, 165, 212);
        margin-left: auto;
        margin-right: auto;
        height: 200px;
    }

    .tableHeader{
        border: 4px solid white;
        font-size: 24px;
        text-align: center;
        height: 60px;
        padding: 15px;
    }

    th{
        font-size: 18px;
        padding-top: 20px;
        padding-bottom: 20px;
        padding-left: 20px;
    }
</style>

<div class="p-5 bg-dark">
    <h1 class = "text-light" style="text-align: center; text-decoration: underline">Data Dictionary</h1>
    <br>
    <p class = "text-light" style="text-align: center"> Below is an alphabetically ordered data dictionary that describes the attributes
        within each table in our database.</p>
    <br>
    
    <table>
        <tr>
            <th class="tableHeader">CART</th>
        </tr>
        <tr>
            <th>&#9900 Customer_ID - The ID of the customer.
                This value is a foreign key from the Customer_ID column in the Customer table.</th>
        </tr>
        <tr>
            <th>&#9900 Item_Number - The number associated with an item.
                This value is a foreign key from the Item_Number in the Items table. </th>
        </tr>
        <tr>
            <th>&#9900 Quantity_of_Item - The quantity of each item in the customer’s cart.
                Valid values are any integers 1 or greater. Functionally determined by Customer_ID and Item_Number.</th>
        </tr>
    </table>
    <br><br>

    <table>
        <tr>
            <th class="tableHeader">CATEGORIES</th>
        </tr>
        <tr>
            <th>&#9900 Category_ID - The ID associated with the category.
                Valid values are any integer 1 or greater. This value must be unique and is auto-incrementing.
                It functionally determines all the non-key attributes in the Category table. This value is a primary key of the table.</th>
        </tr>
        <tr>
            <th>&#9900 Category_Desc - The description of the category.
                Valid values are any string of up to 255 characters. Functionally determined by Category_ID. </th>
        </tr>
        <tr>
            <th>&#9900 Category_type - The type of the category.
                Valid values are any valid category names. Functionally determined by Category_ID.</th>
        </tr>
    </table>
    <br><br>

    <table>
        <tr>
            <th class="tableHeader">CUSTOMER</th>
        </tr>
        <tr>
            <th>&#9900  Customer_ID - The ID of the customer. Valid values are any integer 1 or greater.
                This value must be unique and is auto-incrementing. It functionally determines all the non-key attributes in the Customer table.
                This value is a primary key of the table. </th>
        </tr>
        <tr>
            <th>&#9900  First_name - The first name of the customer. Valid values are any valid name.
                Functionally determined by Customer_ID.</th>
        </tr>
        <tr>
            <th>&#9900  Last_name - The last name of the customer. Valid values are any valid name.
                Functionally determined by Customer_ID.</th>
        </tr>
        <tr>
            <th>&#9900  Age - The age of the customer. Valid values are any integer 0 or greater.
                Functionally determined by Customer_ID.</th>
        </tr>
        <tr>
            <th>&#9900  Pref_gender - The preferred gender of the customer. Valid values are “Male” and “Female.” This attribute can be a NULL value.
                Functionally determined by Customer_ID. </th>
        </tr>
        <tr>
            <th>&#9900  Phone_number - The phone number of the customer.
                Valid values are any string of numbers that have a length of ten. Functionally determined by Customer_ID.</th>
        </tr>
        <tr>
            <th>&#9900  Address - The address of the customer. Valid values are any valid address.
                Functionally determined by Customer_ID.</th>
        </tr>
        <tr>
            <th>&#9900  Email - The email of the customer. Valid values are any valid emails.
                Functionally determined by Customer_ID.</th>
        </tr>
        <tr>
            <th>&#9900  Username - The username of the customer.
                Valid values are any valid usernames. Functionally determined by Customer_ID.</th>
        </tr>
        <tr>
            <th>&#9900  Password - The password of the customer.
                Valid values are any valid passwords. Functionally determined by Customer_ID.</th>
        </tr>
    </table>
    <br><br>

    <table>
        <tr>
            <th class="tableHeader">FAVORITES</th>
        </tr>
        <tr>
            <th>&#9900 Customer_ID - The ID of the customer.
                This value is a foreign key from the Customer_ID column in the Customer table.</th>
        </tr>
        <tr>
            <th>&#9900 Item_Number - The number associated with an item.
                This value is a foreign key from the Item_Number in the Items table.</th>
        </tr>
        <tr>
            <th>&#9900 Date_Added - The date an item was favorited by a customer.
                Valid values are any valid dates. Functionally determined by Customer_ID.</th>
        </tr>
    </table>
    <br><br>

    <table>
        <tr>
            <th class="tableHeader">ITEMS</th>
        </tr>
        <tr>
            <th>&#9900 Item_Number - The ID associated with the item. Valid values are any integer 1 or greater.
                This value must be unique and is auto-incrementing. It functionally determines all the non-key attributes in the Items table.
                This value is a primary key of the table.</th>
        </tr>
        <tr>
            <th>&#9900 Item_Name - The name of the item.
                Valid values are any valid name. Functionally determined by Item_Number.</th>
        </tr>
        <tr>
            <th>&#9900 Price - The price of the item.
                Valid values are any numbers that have a length of eight, with two digits after the decimal point.
                Functionally determined by Item_Number. </th>
        </tr>
        <tr>
            <th>&#9900 Total_in_Stock - The total amount of the item that is in stock.
                Valid values are any integer 0 or greater.  Functionally determined by Item_Number.</th>
        </tr>
        <tr>
            <th>&#9900 Category_ID - The ID of the item category.
                This value is a foreign key from the Category_ID column in the Category table. Functionally determined by Item_Number. </th>
        </tr>
        <tr>
            <th>&#9900 Item_Description - The description of the item. Valid values are any string of up to 255 characters.
                Functionally determined by Item_Number.</th>
        </tr>
        <tr>
            <th>&#9900 Manufacturer - The manufacturer of the item. Valid values are any valid manufacturer name.
                Functionally determined by Item_Number. </th>
        </tr>
    </table>
    <br><br>

    <table>
        <tr>
            <th class="tableHeader">ORDER</th>
        </tr>
        <tr>
            <th>&#9900 Order_ID - The ID associated with a customer’s order.
                Valid values are any integer 1 or greater. This value must be unique and is auto-incrementing.
                It functionally determines all the non-key attributes in the Customer table. This value is a primary key of the table.</th>
        </tr>
        <tr>
            <th>&#9900 Shipping_Addr - The shipping address listed for the order.
                Valid values are any valid address. Functionally determined by Order_ID.</th>
        </tr>
        <tr>
            <th>&#9900 Billing_Addr - The billing address listed for the order.
                Valid values are any valid address. Functionally determined by Order_ID.</th>
        </tr>
        <tr>
            <th>&#9900 Est_Delivery_Date - The established delivery date of the order.
                Valid values are any valid dates. Functionally determined by Order_ID.</th>
        </tr>
    </table>
    <br><br>

    <table>
        <tr>
            <th class="tableHeader">ORDER DETAIL</th>
        </tr>
        <tr>
            <th>&#9900 Order Detail_ID - The ID associated with a customer’s order details.
                Valid values are any integer 1 or greater. This value must be unique and is auto-incrementing.
                It functionally determines all the non-key attributes in the Order Detail table.
                This value is a primary key of the table.</th>
        </tr>
        <tr>
            <th>&#9900 Order_ID - The ID associated with a customer’s order.
                This value is a foreign key from the Order_ID in the Order table.</th>
        </tr>
        <tr>
            <th>&#9900 Item_Number - The number associated with an item.
                This value is a foreign key from the Item_Number in the Items table.</th>
        </tr>
        <tr>
            <th>&#9900 Quantity_of_Item - The quantity of each item in the customer’s order.
                Valid values are any integers 1 or greater. Functionally determined by Order Detail_ID and Order_ID.</th>
        </tr>
        <tr>
            <th>&#9900 Cost - The cost of an item in the order.
                Valid values are any numbers that have a length of eight, with two digits after the decimal point.
                Functionally determined by Order Detail_ID and Order_ID.. </th>
        </tr>
    </table>
    <br><br>

    <table>
        <tr>
            <th class="tableHeader">ORDER PAYMENT</th>
        </tr>
        <tr>
            <th>&#9900 Order_ID - The ID associated with a customer’s order.
                This value is a foreign key from the Order_ID in the Order table.</th>
        </tr>
        <tr>
            <th>&#9900 Customer_ID - The ID of the customer.
                This value is a foreign key from the Customer_ID column in the Customer table.</th>
        </tr>
        <tr>
            <th>&#9900 Amount - The total amount of the order,
                which is the sum of all item costs in the order plus any tax or shipping costs.
                Valid values are any numbers that have a length of eight, with two digits after the decimal point. Functionally determined by Order Detail_ID and Order_ID.</th>
        </tr>
        <tr>
            <th>&#9900 Payment_no - The number associated with an order payment. Valid values are any integer 1 or greater.
                Functionally determined by Order Detail_ID and Customer_ID.</th>
        </tr>
    </table>
    <br><br>

    <table>
        <tr>
            <th class="tableHeader">PAYMENT METHODS</th>
        </tr>
        <tr>
            <th>&#9900 Customer_ID - The ID of the customer.
                This value is a foreign key from the Customer_ID column in the Customer table.</th>
        </tr>
        <tr>
            <th>&#9900 Payment_type - The type of payment method of the customer. Valid values are “Credit” and  “Debit.”
                Functionally determined by Customer_ID.</th>
        </tr>
        <tr>
            <th>&#9900 Card_number - The card number associated with the payment type of the customer.
                Valid values are any valid card numbers that have a length of 16. Functionally determined by Customer_ID.</th>
        </tr>
    </table>
    <br><br>

    <table>
        <tr>
            <th class="tableHeader">PREVIOUS PURCHASES</th>
        </tr>
        <tr>
            <th>&#9900 Customer_ID - The ID of the customer.
                This value is a foreign key from the Customer_ID column in the Customer table.</th>
        </tr>
        <tr>
            <th>&#9900 Order_number - The order number of a customer’s previous purchase.
                Valid values are any valid order numbers. Functionally determined by Customer_ID.</th>
        </tr>
        <tr>
            <th>&#9900 Date_added - The date of when the order was purchased.
                Valid vales are any valid date. Functionally determined by Customer_ID. </th>
        </tr>
    </table>
    <br><br>

    <table>
        <tr>
            <th class="tableHeader">REVIEWS</th>
        </tr>
        <tr>
            <th>&#9900 Customer_ID - The ID of the customer.
                This value is a foreign key from the Customer_ID column in the Customer table.</th>
        </tr>
        <tr>
            <th>&#9900 Item_Number - The number associated with an item.
                This value is a foreign key from the Item_Number in the Items table.</th>
        </tr>
        <tr>
            <th>&#9900 Date_added - The date the review was added by a customer.
                Valid values are any valid dates. Functionally determined by Customer_ID. </th>
        </tr>
    </table>
</div>

<?php include_once("footer.php")?>
