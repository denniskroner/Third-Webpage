<?php require 'database.php';?>

<!--
    SQL query on page load
    required to get the product lines infos
-->
<?php
    //create array to store each product line category
    $Product_Line=array();

    //creating an array which will contain the values from the database
    $arr_PL = array(
        "productLine" => array(),
        "textDescription" => array()
        );

    //create SQL for query
    $sql = 'SELECT productLine,
            textDescription
            FROM productlines
            ORDER BY productLine';
    //connect to database    
    $conn=DBconnect();
    //execute the query
    $q=SQLquery($sql, $conn);
    //fetching data by row
    while ($r = $q->fetch()){
        //store product line category in array
        array_push($Product_Line, htmlspecialchars($r['productLine']));
        array_push($arr_PL["productLine"], htmlspecialchars($r['productLine']));
        array_push($arr_PL["textDescription"], htmlspecialchars($r['textDescription']));
    }
?> 


<!--html webpage creation-->
<!DOCTYPE html>
<html>
<head>
    <title>PHP Classicmodels Database</title>
    <link  rel="stylesheet" href="index.css">
</head>

<body>     
<section>
    <nav>
        <!--include the php containing the navigation bar-->
        <?php require 'NavBar.php';?>
    </nav>
    
    <article>
        <div>
            <form method="get" action="<?php echo $_SERVER["PHP_SELF"];?>">
                <select id="sel_PLine" name="ProductLine">
                    <!--options to select dynamically created with JavaScript-->
                </select>
                <input type="submit">
            </form>
            
            <div id="DB_table">
                <!--table dynamically created with js-->
            </div>
        </div>
    </article>
</section>
<footer>
    <!--include the php containing the footer-->
    <?php include 'Footer.php';?>
</footer> 
<!--end of html webpage creation-->
    
    
<!--JS to create table with whole product line-->
<script>
    //get the array from php
    var SQL_arr = <?php echo json_encode($arr_PL); ?>;

    //create output for html table
    var out = "<h1 id=h_productLine>Product Lines</h1>" +
                "<table id='productLine'>" +
                    "<tr>" +
                        "<th>Product Lines</th>" +
                        "<th>Description</th>" +
                    "</tr>";

    //determine the length of the sub-arrays
    var arr_len = 0;
    for(i in SQL_arr){
        arr_len = Math.max(arr_len, SQL_arr[i].length);
    }

    //looping through each row of the sub-arrays
    for(row = 0; row < arr_len; row++){
        //creating each html row
        out += "<tr>";
        for(arr_name in SQL_arr){
            out += "<td>"+ SQL_arr[arr_name][row] +"</td>";
        }
        out += "</tr>";
    }
    //close the table
    out += "</table>";
    //display output
    document.getElementById("DB_table").innerHTML = out;            
</script>
<!--end JS to create table with whole product line-->
    

<!--create options for form selection-->
<?php
    /*  base case on page creation
        nothing can be selected, therefore,
        the empty option is selected
    */
    if (count($_GET) === 0) {
        $prodOutput = "<script>var text = '<option value=\"\" Selected> </option>';";
        foreach ($Product_Line as $product){
            $prodOutput .= "text += '<option value=\"" . $product . "\">" . $product . "</option>';";
        }
    }
    /*
        after the option of the selection from are 
        created check which option was chosen and 
        change the option to selected
    */
    else{
        $prodOutput = "<script>var text = '<option value=\"\" Selected> </option>';";
        foreach ($Product_Line as $product){
            if ($_GET["ProductLine"] === $product) {
                $selected = "Selected";
            }
            else{
                $selected = "";    
            }
            $prodOutput .= "text += '<option value=\"" . $product . "\" " . $selected .">" . $product . "</option>';";
        }
    }
    //add the options to the selection form
    $prodOutput .= "document.getElementById('sel_PLine').innerHTML = text;</script>";
    echo $prodOutput;
?>
<!--end create option-->

<!--create table with all products of a selected product line using PHP and JS-->
<?php
    $Product = "";
    /*
        on page creation nothing can be selected
        therefore display the whole product line
    */
    if (count($_GET) !== 0) {
        $Product = $_GET["ProductLine"];
    }

    //if a product category was selected enter if statement
    if ( $Product !== '' ):
        //create SQL for query
        $sql = 'SELECT *
                FROM products
                WHERE productLine="' . $_GET["ProductLine"] . '"';
        //connect to database    
        $conn=DBconnect();
        //execute the query
        $q=SQLquery($sql, $conn);
        //fetching data by row

        //creating an array which will contain the values from the database
        $arr = array(
            "productCode" => array(),
            "productName" => array(),
            "productLine" => array(),
            "productScale" => array(),
            "productVendor" => array(),
            "productDescription" => array(),
            "quantityInStock" => array(),
            "buyPrice" => array(),
            "MSRP" => array()
            );
        //put the values from the database into the arrays
        while ($r = $q->fetch()){
            array_push($arr["productCode"],htmlspecialchars($r['productCode']));
            array_push($arr["productName"],htmlspecialchars($r['productName']));
            array_push($arr["productLine"],htmlspecialchars($r['productLine']));
            array_push($arr["productScale"],htmlspecialchars($r['productScale']));
            array_push($arr["productVendor"],htmlspecialchars($r['productVendor']));
            array_push($arr["productDescription"],htmlspecialchars($r['productDescription']));
            array_push($arr["quantityInStock"],htmlspecialchars($r['quantityInStock']));
            array_push($arr["buyPrice"],htmlspecialchars($r['buyPrice']));
            array_push($arr["MSRP"],htmlspecialchars($r['MSRP']));
        }
?>  
    <script>
        //hide the table with product lines
        document.getElementById("productLine").style.display = "none";
        document.getElementById("h_productLine").style.display = "none";

        //get the array from php
        var SQL_arr = <?php echo json_encode($arr); ?>;

        //creating the html table and header output
        var out = "<h1><?php echo $_GET["ProductLine"]; ?></h1>" +
                  "<table id='Products'>" +
                        "<tr>" +
                            "<th>Product Code</th>" +
                            "<th>Product Name</th>" +
                            "<th>Product Line</th>" +
                            "<th>Product Scale</th>" +
                            "<th>Product Vendor</th>" +
                            "<th>Product Description</th>" +
                            "<th>Product Available</th>" +
                            "<th>Product Price</th>" +
                            "<th>MSRP</th>" +
                        "</tr>";

        //determine the length of the sub-arrays
        var arr_len = 0;
        for(i in SQL_arr){
            arr_len = Math.max(arr_len, SQL_arr[i].length);
        }

        //looping through each row of the sub-arrays
        for(row = 0; row < arr_len; row++){
            //creating each html row
            out += "<tr>";
            for(arr_name in SQL_arr){
                out += "<td>"+ SQL_arr[arr_name][row] +"</td>";
            }
            out += "</tr>";
        }
        //close the table
        out += "</table>";
        //display output
        document.getElementById("DB_table").innerHTML = out;
    </script>
<?php
    endif; 
?>
<!--end create table with all products of a selected product line using PHP and JS-->
</body>
</html>