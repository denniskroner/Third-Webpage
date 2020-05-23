<?php require 'database.php';?>

<!--
    SQL query on page load
    required to get the customer infos
-->
<?php
    //creating an array which will contain the values from the database
    $arr_customer = array(
        "customerName" => array(),
        "country" => array(),
        "city" => array(),
        "phone" => array()
        );

    //create SQL for query
    $sql = 'SELECT customerName, 
        country,
        city,
        phone
        FROM customers
        ORDER BY country'; 
    //connect to database    
    $conn=DBconnect();
    //execute the query
    $q=SQLquery($sql, $conn);
    //fetching data by row
    while ($r = $q->fetch()){
        array_push($arr_customer["customerName"], htmlspecialchars($r['customerName']));
        array_push($arr_customer["country"], htmlspecialchars($r['country']));
        array_push($arr_customer["city"], htmlspecialchars($r['city']));
        array_push($arr_customer["phone"], htmlspecialchars($r['phone']));       
    }

?>


<!--html webpage creation-->
<!DOCTYPE html>
<html>
<head>
    <title>PHP Classicmodels Database</title>
    <link  rel="stylesheet" href="customers.css">
</head>

    
<body>
<section>
    <nav>
        <!--include the php containing the navigation bar-->
        <?php require 'NavBar.php';?>
    </nav>
    
    <article>
        <div id="customer_Table">
            <!--table dynamically created with js-->
        </div>
    </article>
</section>
        
<footer>
    <!--include the php containing the footer-->
    <?php include 'Footer.php';?>
</footer>
<!--end of html webpage creation-->
    
<!--js creating the html table for customer infos-->
<script>
        //get the array from php
        var SQL_arr = <?php echo json_encode($arr_customer); ?>;

        //creating the html table and header output
        var out = "<h1>Customers</h1>" +
                  "<table id='customer'>" +
                        "<tr>" +
                            "<th>Name</th>" +
                            "<th>Country</th>" +
                            "<th>City</th>" +
                            "<th>Phone</th>" +
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
        document.getElementById("customer_Table").innerHTML = out;   
</script>
<!-- end js creating the html table for customer infos-->    
</body>
</html>