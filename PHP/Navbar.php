<style>
nav {
    border-bottom: 3px solid ghostwhite;
    line-height: 50px;
    width: 100%;
}    

nav:after {
  content: "";
  display: table;
  clear: both;
}    
    
nav ul {
    float: right;
    list-style-type: none;
    overflow: hidden;
    margin: 0;
    padding: 0;
    background-color: rgb(255, 255, 255);
}

nav ul li {
    float: left;
    margin: 0 2px;
}

nav li a{
    text-decoration: none;
    text-align: center;
    display: block;
    color: rgb(0, 0, 0);
    font-size: 18px;
    font-family: sans-serif;
    padding: 0 20px;
    font-weight: bold;
}

nav li a:hover{
    background-color: rgb(0, 0, 0);
    color: rgb(255, 255, 255);
}  
    
nav span {
    float: left;
    font-size: 22px;
    font-weight: bold;
    padding: 0 10px;
    background-color: rgb(0, 0, 0);
    color: rgb(255, 255, 255);
    
}    
</style>

<?php
echo '<span>Classic Models</span>
      <ul>
        <li><a href="Index.php">Product Lines</a></li>
        <li><a href="Customers.php">Customers</a></li>
        <li><a href="Orders.php">Orders</a></li>
     </ul>';
?>