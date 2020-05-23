<style> 
    
footer #info {
    background-color: rgb(30, 30, 30);
    padding: 20px 0px;
    width: 100%;
}

footer table {
    color: rgb(255, 255, 255);
    width: 500px;
    margin-left: auto;
    margin-right: auto;
    padding: 0px 20px;
}

footer table td {
    font-size: 18px;
}     
    
footer table th {
    font-weight: bold;
    text-align: left;
    font-size: 20px;
}

footer #disclaimer {
    background-color: rgb(0, 0, 0);
    color: rgb(255, 255, 255);
    text-align: center;
    padding: 15px 0px;
    font-size: 14px;
    font-family: sans-serif;
    width: 100%;
}

footer p:first-child {
    font-weight: bold;
    font-size: 16px;
}

footer #disclaimer span:hover,
footer table td span:hover {
    text-decoration-line: underline;
    cursor: pointer;
}
</style>




<?php
echo '<div id="info">
            <table>
                <tr>
                    <th><span>Customer Servie</span></th>
                    <th><span>About Us</span></th>
                    <th><span>Shop</span></th>
                </tr>
                <tr>
                    <td><span>Sign In/Register</span></td>
                    <td><span>Our Story</span></td>
                    <td><span>Best Seller</span></td>
                </tr>
                <tr>
                    <td><span>Contact Us</span></td>
                    <td><span>Reviews</span></td>
                    <td><span>New</span></td>
                </tr>
                <tr>
                    <td><span>Shipping</span></td>
                    <td><span>Careers</span></td>
                    <td><span>Shop All</span></td>
                </tr>
                <tr>
                    <td><span>Returns</span></td>
                    <td><span>Help Center</span></td>
                    <td><span>Reviews</span></td>
                </tr>
            </table>
        </div>
        <div id="disclaimer">
            <p>Copyright © 2019 Classic Models Company. All Rights Reserved</P>
            <span>Partnershisp</span> - 
            <span>Terms & Privacy</span> - 
            <span>Help & FAQ</span> - 
            <span>Disclaimer</span>
        </div>';
?>