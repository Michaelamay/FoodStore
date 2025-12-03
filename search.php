<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//include_once('../connect.php');
include 'connect.php';
//help identify whats on the url.
$filter = explode('=', $_SERVER['QUERY_STRING'])[1];
//var_dump($filter);

if ($filter) {
    $searchTerms = explode(',', $filter);
    //echo "<br>";
    //var_dump($searchTerms);

    //Create SQL query to call from table
    $statement = "SELECT * FROM Recipe WHERE JSON_CONTAINS(Ingredients,?)";
    $query = $conn->prepare($statement);
    $query->bind_param('s', json_encode($searchTerms));

    /*
    echo "query.execute: ";
    var_dump($query->execute());
    echo "<br>";
    */

    //Execute the query and return the success status.
    $resStat = $query->execute();

    //var_dump($resStat);

    //excutes fine.

    if ($resStat == TRUE) {

        //this grabs the data from the table. Descriptive format.
        $result = $query->get_result();
        //var_dump($result);

        $data = $result->fetch_all(MYSQLI_ASSOC);

        //echo "<br>";

        //var_dump($data);
        //$data = [];
        //echo "<br>";


        /*
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo "row: ";
        var_dump($row);
        */


        /*
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
            echo "row: ";
            var_dump($row);
        }
        */


        http_response_code(200);

        /*
        var_dump(
            $data,
            json_encode($data,JSON_NUMERIC_CHECK)
        );
        */

        echo json_encode($data, JSON_NUMERIC_CHECK);

        $result->close();
    }
} else {
    http_response_code(400);
    echo "Bad Request";
}
?>