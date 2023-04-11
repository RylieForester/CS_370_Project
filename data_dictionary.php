<?php include_once("header.php")?>

<div class="p-5 bg-dark">
    <h1 class = "text-light" style="text-align: center; text-decoration: underline">Data Dictionary</h1>
    <p class = "text-light" style="text-align: center"> Below is a data dictionary that describes the attributes
        within each table in our database in alphabetical order.</p>
    <br>

    <table style="border: 1px solid white; background-color: rgb(94, 165, 212); margin-left: auto; margin-right: auto; height: 200px">
        <tr>
            <th style="border: 1px solid white; font-size: 22px; text-align: center; height: 40px">CART</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900 Customer_ID - The ID of the customer.
                This value is a foreign key from the Customer_ID column in the Customer table.</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900 Item_Number - The number associated with an item.
                This value is a foreign key from the Item_Number in the Items table. </th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px; padding-bottom: 15px">&#9900 Quantity_of_Item - The quantity of each item in the customer’s cart.
                Valid values are any integers 1 or greater. Functionally determined by Customer_ID and Item_Number.</th>
        </tr>
    </table>
    <br><br>

    <table style="border: 1px solid white; background-color: rgb(94, 165, 212); margin-left: auto; margin-right: auto; height: 200px">
        <tr>
            <th style="border: 1px solid white; font-size: 22px; text-align: center; height: 40px">CATEGORIES</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900 Category_ID - The ID associated with the category.
                Valid values are any integer 0 or greater. This value must be unique and is auto-incrementing.
                It functionally determines all the non-key attributes in the Category table. This value is a primary key of the table.</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900 Category_Desc - The description of the category.
                Valid values are strings of up to 255 characters. Functionally determined by Category_ID. </th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px; padding-bottom: 15px">&#9900 Category_type - The type of the category.
                Valid values are any valid category names. Functionally determined by Category_ID.</th>
        </tr>
    </table>
    <br><br>

    <table style="border: 1px solid white; background-color: rgb(94, 165, 212); margin-left: auto; margin-right: auto; height: 200px">
        <tr>
            <th style="border: 1px solid white; font-size: 22px; text-align: center; height: 40px">CUSTOMER</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900  Customer_ID - The ID of the customer. Valid values are any integer 0 or greater.
                This value must be unique and is auto-incrementing. It functionally determines all the non-key attributes in the Customer table.
                This value is a primary key of the table. </th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900  First_name - The first name of the customer. Valid values are any valid name.
                Functionally determined by Customer_ID.</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900  Last_name - The last name of the customer. Valid values are any valid name.
                Functionally determined by Customer_ID.</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900  Age - The age of the customer. Valid values are any integer 0 or greater.
                Functionally determined by Customer_ID.</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900  Pref_gender - The preferred gender of the customer. Valid values are “Male” and “Female.”
                Functionally determined by Customer_ID. </th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900  Phone_number - The phone number of the customer.
                Valid values are any string of numbers that have a length of ten. Functionally determined by Customer_ID.</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900  Address - The address of the customer. Valid values are any valid address.
                Functionally determined by Customer_ID.</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900  Email - The email of the customer. Valid values are any valid emails.
                Functionally determined by Customer_ID.</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900  Username - The username of the customer.
                Valid values are any valid usernames. Functionally determined by Customer_ID.</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px; ; padding-bottom: 15px">&#9900  Password - The password of the customer.
                Valid values are any valid passwords. Functionally determined by Customer_ID.</th>
        </tr>
    </table>
    <br><br>

    <table style="border: 1px solid white; background-color: rgb(94, 165, 212); margin-left: auto; margin-right: auto; height: 200px">
        <tr>
            <th style="border: 1px solid white; font-size: 22px; text-align: center; height: 40px">FAVORITES</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900 Customer_ID - The ID of the customer.
                This value is a foreign key from the Customer_ID column in the Customer table.</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900 Item_Number - The number associated with an item.
                This value is a foreign key from the Item_Number in the Items table.</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px; padding-bottom: 15px">&#9900 Date_Added - The date an item was added favorited by a customer.
                Valid values are any valid dates. Functionally determined by Customer_ID.</th>
        </tr>
    </table>
    <br><br>

    <table style="border: 1px solid white; background-color: rgb(94, 165, 212); margin-left: auto; margin-right: auto; height: 200px">
        <tr>
            <th style="border: 1px solid white; font-size: 22px; text-align: center; height: 40px">ITEMS</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900 Item_Number - The ID associated with the item. Valid values are any integer 0 or greater.
                This value must be unique and is auto-incrementing. It functionally determines all the non-key attributes in the Items table.
                This value is a primary key of the table.</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900 Item_Name - The name of the item.
                Valid values are any valid name. Functionally determined by Item_Number.</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900 Price - The price of the item.
                Valid values are any numbers that have a length of eight, with two digits after the decimal point.
                Functionally determined by Item_Number. </th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900 Total_in_Stock - The total amount of the item that is in stock.
                Valid values are any integer 0 or greater.  Functionally determined by Item_Number.</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900 Category_ID - The ID of the item category.
                This value is a foreign key from the Category_ID column in the Category table. Functionally determined by Item_Number. </th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900 Item_Description - The description of the item. Valid values are any string of up to 255 characters.
                Functionally determined by Item_Number.</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px; padding-bottom: 15px">&#9900 Manufacturer - The manufacturer of the item. Valid values are any valid manufacturer name.
                Functionally determined by Item_Number. </th>
        </tr>
    </table>
    <br><br>

    <table style="border: 1px solid white; background-color: rgb(94, 165, 212); margin-left: auto; margin-right: auto; height: 200px">
        <tr>
            <th style="border: 1px solid white; font-size: 22px; text-align: center; height: 40px">ORDER</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900 Order_ID - The ID associated with a customer’s order.
                Valid values are any integer 0 or greater. This value must be unique and is auto-incrementing.
                It functionally determines all the non-key attributes in the Customer table. This value is a primary key of the table.</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900 Shipping_Addr - The shipping address listed for the order.
                Valid values are any valid address. Functionally determined by Order_ID.</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900 Billing_Addr - The billing address listed for the order.
                Valid values are any valid address. Functionally determined by Order_ID.</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px; padding-bottom: 15px">&#9900 Est_Delivery_Date - The established delivery date of the order.
                Valid values are any valid dates. Functionally determined by Order_ID.</th>
        </tr>
    </table>
    <br><br>

    <table style="border: 1px solid white; background-color: rgb(94, 165, 212); margin-left: auto; margin-right: auto; height: 200px">
        <tr>
            <th style="border: 1px solid white; font-size: 22px; text-align: center; height: 40px">ORDER</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900 Order_ID - The ID associated with a customer’s order.
                Valid values are any integer 0 or greater. This value must be unique and is auto-incrementing.
                It functionally determines all the non-key attributes in the Customer table. This value is a primary key of the table.</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900 Shipping_Addr - The shipping address listed for the order.
                Valid values are any valid address. Functionally determined by Order_ID.</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px">&#9900 Billing_Addr - The billing address listed for the order.
                Valid values are any valid address. Functionally determined by Order_ID.</th>
        </tr>
        <tr>
            <th style="padding-top: 15px; padding-left: 10px; padding-bottom: 15px">&#9900 Est_Delivery_Date - The established delivery date of the order.
                Valid values are any valid dates. Functionally determined by Order_ID.</th>
        </tr>
    </table>


</div>

<?php include_once("footer.php")?>
