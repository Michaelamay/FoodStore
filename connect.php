<?php
    $version = phpversion();
    //echo "version: ". $version . "<br>";

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbName = "FoodDB";

    //Create connection
    $conn = mysqli_connect($servername, $username, $password,$dbName);

    //Check connection
    if($conn->connect_error) {
        die("Connection failed:" . $conn->connect_error);
        echo "Database Connection failed" . '<br>';
        exit();
    }else{
        //echo"Connected!";
        /*
        $sql = "SELECT * FROM Recipe;";
        $result = mysqli_query($conn,$sql);

        //var_dump($result);
        while($row = mysqli_fetch_array($result)){
            var_dump($row);
        }
        */
    }
    

?>
