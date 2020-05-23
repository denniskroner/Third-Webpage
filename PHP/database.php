<!--DB prepatation-->
<?php
function DBconnect(){
        $host = 'localhost';
        $dbname = 'classicmodels';
        $username = 'root';
        $password = '';
    
    try {
        //connection to the database
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $conn;

    } catch (PDOException $pe) {
        catchDBerror($pe->getCode());
        die("Could not connect to the database: $dbname");
    }
    
    //close the connection to the server
    $conn = null;
}
?>


<!--SQL query-->
<?php
    function SQLquery($sql, $conn){
        try {
            $q = $conn->query($sql);
            $q->setFetchMode(PDO::FETCH_ASSOC);
        
            return $q;
        } catch (PDOException $pe) {
            catchDBerror($pe->getCode(), $pe->getFile());
            die("SQL query not executed: $sql"); 
        }
    }
?>

 
<?php
    function catchDBerror($errorCode, $errorfile = null){
        //errorCode 1044 => wrong username
        //errorCode 1045 => wrong password
        //errorCode 1049 => wrong DBname
        //errorCode 2002 => wrong host
        
        switch($errorCode){
            case 1044:
                $err="Error: unknown username! Change username and connect again.";
                break;
            case 1045:
                $err="Error: wrong password! Change password and connect again.";
                break;
            case 1049:
                $err="Error: unknown database name! Change database name and connect again.";
                break;
            case 2002:
                $err="Error: unknown host! Change host and connect again.";
                break;
            case "42S22":
                $err="Error: SQL query seems to be wrong! Change query in file: '". $errorfile ."' and try again.";
                break;
            default:
                $err="Undefined error! Error code: " . $errorCode;
        }
        
        echo '<script>res=confirm("' . $err .'\n\nTry to connect again?")</script>';
        
        echo '<script>if (res) {location.reload();}</script>';
    }

?>
