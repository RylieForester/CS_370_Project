<?php include_once("header.php")?>

<div class="p-5 bg-dark">
    <h1 class="text-light" style="text-align: center; text-decoration: underline">Welcome</h1>
    <br>

    <p class="text-light" style="text-align: justify; font-size: 20px">
        We are Team #1 and our Amazon-like online retailer stores various types of data related to our customers,
        different aspects of their accounts, such as favorites and payment methods, and various items that one could purchase.
        This website allows one to learn and familiarize themselves with the inner workings of our database, as well as import
        data via csv files and view the results of those imports via reports.
    </p>
    <br>

    <p class="text-light" style="text-align: justify; font-size: 20px">
        Navigation links are located at the top of the website and can be found in the same place on every web page.
        A more in-depth explanation of each link is outlined below:
    </p>

    <ul class="text-light" style="text-align: justify; font-size: 20px">
        <li style="padding-top: 15px; padding-bottom: 15px"><u>Home</u> - This link brings you back to this page.</li>

        <li style="padding-top: 15px; padding-bottom: 15px"><u>Data Dictionary</u> - This link lists all the attributes in
            each table in our database and provides more information about each one.</li>

        <li style="padding-top: 15px; padding-bottom: 15px"><u>ER Diagram</u> - This link displays an image depicting an entity
            relationship diagram based on our database. One can see the various tables, with their attributes, in our
            database and how they relate to each other.</li>

        <li style="padding-top: 15px; padding-bottom: 15px"><u>Import Data</u> - This is a dropdown menu that allows one
            to import various csv files containing data that pertains to specific tables in our database.

            <ul class="text-light" style="text-align: justify; font-size: 20px">
                <li style="padding-top: 15px; padding-bottom: 15px"><u>Import Data 1</u> - This link imports data into the
                    Categories, Items, & Reviews tables of our database.</li>
                <li style="padding-top: 15px; padding-bottom: 15px"><u>Import Data 2</u> - This link imports data into the
                    Customer, Cart, & Payment Methods tables of our database.</li>
                <li style="padding-top: 15px; padding-bottom: 15px"><u>Import Data 3</u> - This link imports data into the
                    Order, Order Detail, & Order Payment tables of our database.</li>
            </ul>

            <p style="color: rgb(221, 96, 84)"><strong>*It is important to note that one <u>must</u> implement the second import
                    (Import Data 2), the third import (Import Data 3), and then the first Import (Import Data 1)
                    due to how our database is structured.</strong></p>
        </li>

        <li style="padding-bottom: 15px"><u>Data Reports</u> - This is a dropdown menu that allows one to
            import various csv files containing data that pertains to specific tables in our database.

            <ul class="text-light" style="text-align: justify; font-size: 20px">
                <li style="padding-top: 15px; padding-bottom: 15px"><u>Report 1</u> - This link reports on the imported data
                    in the Order, Order Detail, & Order Payment tables from Import Data 1.</li>
                <li style="padding-top: 15px; padding-bottom: 15px"><u>Report 2</u> - This link reports on the imported data
                    in the Categories, Items, & Reviews tables from Import Data 2.</li>
                <li style="padding-top: 15px; padding-bottom: 15px"><u>Report 3</u> - This link reports on the imported data
                    in the Customer, Cart, & Payment Methods tables from Import Data 3.</li>
            </ul>
        </li>
    </ul>
    <br>

    <p class="text-light" style="text-align: justify; font-size: 20px">Please click on one of the links at the top of this page to get started.</p>
</div>

<?php include_once("footer.php")?>
