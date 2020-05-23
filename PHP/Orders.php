<?php require 'database.php';?>

<!--
    SQL query on page load
    required to get the order infos
-->
<?php
    function Orders_arr($sql){
        $arr_Orders = array(
            "orderNumber" => array(),
            "orderDate" => array(),
            "status" => array()
        ); 
        
        //connect to database    
        $conn=DBconnect();
        //execute the query
        $q=SQLquery($sql, $conn);
        //fetching data by row
        while ($r = $q->fetch()){
            //store product line category in array
            array_push($arr_Orders["orderNumber"], htmlspecialchars($r['orderNumber']));
            array_push($arr_Orders["orderDate"], htmlspecialchars($r['orderDate']));
            array_push($arr_Orders["status"], htmlspecialchars($r['status']));
        }
        
        return $arr_Orders;
    }    
    
    $sql = 'SELECT orderNumber, 
            orderDate,
            status
            FROM orders
            Where status="In Process"
            ORDER BY orderNumber desc';
    $arr_InProcess = Orders_arr($sql);

    $sql = 'SELECT orderNumber, 
            orderDate,
            status
            FROM orders
            Where status="Cancelled"
            ORDER BY orderNumber desc';
    $arr_Cancelled = Orders_arr($sql);

    $sql = 'SELECT orderNumber, 
            orderDate,
            status
            FROM orders
            ORDER BY orderDate desc,
            orderNumber desc
            LIMIT 20';
    $arr_MostRecent = Orders_arr($sql);
?>


<!--html webpage creation-->
<!DOCTYPE html>
<html>
<head>
    <title>PHP Classicmodels Database</title>
    <link rel="stylesheet" href="orders.css">
</head>


<body>    
<section>
    <nav>
        <?php require 'NavBar.php';?>
    </nav>
    
    <article>
        <div id="row1">
            <div id="color">
                <div id="middle">
                    <div class="T_header">
                        <h1>Orders in Process</h1>
                    </div>
                    <div class="T_header">
                        <h1>Cancelled Orders</h1>
                    </div>
                    <div class="T_header">
                        <h1>20 Most Recent Orders</h1>
                    </div>
                </div>

            </div>
            <div id="tables">
                <!--tables dynamically created with js-->
            </div>
        </div>
        <div id="row2">
        
        </div>
    </article>
</section>
<footer>
    <?php include 'Footer.php';?>
</footer>
<!--end of html webpage creation-->

        
<!--JS to create the order tables in html-->
<script>
    //get the array from php
    var arr_InProcess = <?php echo json_encode($arr_InProcess); ?>;
    var arr_Cancelled = <?php echo json_encode($arr_Cancelled); ?>;
    var arr_MostRecent = <?php echo json_encode($arr_MostRecent); ?>;
    var finalOutput = "";
    
    function CreateTables(SQL_arr){
        //create output for html table
        var out = "<div class='column'>" +
                    "<table class='orders'>" +
                        "<tr>" +
                            "<th>Order Nr.</th>" +
                            "<th>Order Date</th>" +
                            "<th>Status</th>" +
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
                if (arr_name === "orderNumber"){
                    out += "<td><a href='Orders.php?orderID="+ SQL_arr[arr_name][row] +"'>" + SQL_arr[arr_name][row] + "</a></td>";
                }
                else{
                    out += "<td>"+ SQL_arr[arr_name][row] +"</td>";
                }
            }
            out += "</tr>";
        }
        //close the table
        out += "</table></div>";
        return out;
    }

    finalOutput += CreateTables(arr_InProcess);
    finalOutput += CreateTables(arr_Cancelled);
    finalOutput += CreateTables(arr_MostRecent);
    
    //display output
    document.getElementById("tables").innerHTML = finalOutput;
</script>    
<!--end of JS to create the order tables in html--> 
    
    
<!--php dynamic query to fetch order details-->
<?php
    if (count($_GET) !== 0) {
        $dynSQL = array(
            "orderNumber" => array(),
            "customerNumber" => array(),
            "orderDate" => array(),
            "requiredDate" => array(),
            "shippedDate" => array(),
            "status" => array(),
            "comments" => array(),
            "quantityOrdered" => array(),
            "priceEach" => array(),
            "productCode" => array(),
            "productLine" => array(),
            "productName" => array()
            );
    
        $sql = 'SELECT O.orderNumber, 
            customerNumber,
            orderDate,
            requiredDate,
            shippedDate,
            status,
            comments,
            quantityOrdered,
            priceEach,
            P.productCode,
            productLine,
            productName
            FROM orders as O,
            orderdetails as OD,
            products as P
            WHERE O.orderNumber = OD.orderNumber AND
            OD.productCode = P.productCode AND
            O.orderNumber ="' . $_GET['orderID'] .'"
            ORDER BY orderDate desc';
        //connect to database    
        $conn=DBconnect();
        //execute the query
        $q=SQLquery($sql, $conn);
        //fetching data by row
        while ($r = $q->fetch()){
            //store product line category in array
            array_push($dynSQL["orderNumber"], htmlspecialchars($r['orderNumber']));
            array_push($dynSQL["customerNumber"], htmlspecialchars($r['customerNumber']));
            array_push($dynSQL["orderDate"], htmlspecialchars($r['orderDate']));
            array_push($dynSQL["requiredDate"], htmlspecialchars($r['requiredDate']));
            array_push($dynSQL["shippedDate"], htmlspecialchars($r['shippedDate']));
            array_push($dynSQL["status"], htmlspecialchars($r['status']));
            array_push($dynSQL["comments"], htmlspecialchars($r['comments']));
            array_push($dynSQL["quantityOrdered"], htmlspecialchars($r['quantityOrdered']));
            array_push($dynSQL["priceEach"], htmlspecialchars($r['priceEach']));
            array_push($dynSQL["productCode"], htmlspecialchars($r['productCode']));
            array_push($dynSQL["productLine"], htmlspecialchars($r['productLine']));
            array_push($dynSQL["productName"], htmlspecialchars($r['productName']));
        } 
    }
    else{
        $dynSQL = array();
    }
?>
<!--end of php dynamic query to fetch order details-->
    
    
<!--js to create the table containing the order details-->
<script>
    var SQL_arr = <?php echo json_encode($dynSQL); ?>;
    
    if (SQL_arr.length != 0){
        //creating the html table and header output
        var out = "<div id='color'><h1>Order Details</h1></div>" +
                  "<table id='orderDetails'>" +
                     "<tr>" +
                        "<th>Order Nr.</th>" +
                        "<th>Customer Nr.</th>" +
                        "<th>Order Date</th>" +
                        "<th>Required Date</th>" +
                        "<th>Shipped Date</th>" +
                        "<th>Status</th>" +
                        "<th>Comments</th>" +
                        "<th>Quantity Ordered</th>" +
                        "<th>Price Each</th>" +
                        "<th>Product Code</th>" +
                        "<th>Product Line</th>" +
                        "<th>Product Name</th>" +
                    "</tr>";

        //determine the length of the sub-arrays
        var arr_len = 0;
        for(i in SQL_arr){
            arr_len = Math.max(arr_len, SQL_arr[i].length);
        }

        //looping through each row of the sub-arrays
        for(row = 0; row < arr_len; row++){
            //creating each html row
            out += "<tr id='id-" + SQL_arr["orderNumber"][row] + "'>";
            for(arr_name in SQL_arr){
                out += "<td>"+ SQL_arr[arr_name][row] +"</td>";
            }
            out += "</tr>";
        }
        //close the table
        out += "</table>";
        
        //display output
        document.getElementById("row2").innerHTML = out;     
    }
</script>
<!--end of js to create the table containing the order details-->

</body>
</html>