<html>
<head>
    <!--    CSS-->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
<!--    <h3><a href="SaveList.php">Saved List</a></h3>-->
    
    <?php

    /*use Appwrite\Client;
    use Appwrite\Services\Databases;
    use Appwrite\ID;
    */

    /*require_once 'vendor/autoload.php';*/

    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    //$client = new Client();
    /*
    $client = new Client();

    $client
        ->setEndpoint('https://cloud.appwrite.io/v1')
        ->setProject('679e9f61002e5ffb671b')
        ->setKey('standard_64bbf12c87aee29bfddd6c9e628a36a18aadd35610fc12039ac881fcea899958ec05d1f2822188a65f9ce2cf339e17849666915db27aed0886348672d580646c678545fc9e81c4e63639843a6005e09466ab06149f7cd101bec6a44d03f830c7fa01255382883f5168e7a53a2d4ca2c5a68ea4b9c02194318203f4f8f347fb3b');
    */
    /*
    try{

            $databases = new Databases($client);

    } catch (Exception $e) {

            error_log($e->getMessage(), "\n");

    }
    */
    function get_buttons()
    {

        $str = '&nbsp;<input type="submit" value="Save recipie" name="btn" id="btn"/>';

        return $str;
    }


    //test function
    function click_checker()
    {

        $click = 'Clicked!';
        //check clicked button
        if (isset($_POST['btn'])) {
            //return nl2br(" \n save clicked");
            return $click;
        }


    }


    include 'connect.php';

    //isset is used to check whether a variable is set to or not
    if (isset($_POST['name'])) {

        //checking get method from the form method in navigation page
        if (isset($_GET['go'])) {

            //if you want to print the keyword searched
            //echo $_POST['name'];
    
            $searchtext = $_POST['name'];
            //$url = "https://www.themealdb.com/api/json/v1/1/search.php?s=".$searchtext;
    
            $firstLetter = strtolower($searchtext[0]);

            $url = "https://www.themealdb.com/api/json/v1/1/search.php?f=" . $firstLetter;

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $resp = curl_exec($curl);
            curl_close($curl);

            $decoded_json = json_decode($resp, true);

            $meals = $decoded_json['meals'];

            echo "<table border= '1px';>";


            /*

            strIngredient is an array
            strMeasure is an array
            strMeal is a string
            idMeal is a string
            strInstructions is a large string

            */


            foreach ($meals as $meal) {

                $strmeal = $meal['strMeal'];
                $idMeal = $meal['idMeal'];
                $strInstructions = $meal['strInstructions'];

                //$instruct = $meal['strInstructions'];
    
                //$testIngredientList = $meal['strIngredient'];
                //$testMeasureList = $meal['strMeasure'];
    
                /*
                echo "str meal: ";
                var_dump($strmeal);
                echo "id meal: ";
                var_dump($idMeal);
                echo "str instructions: ";
                var_dump($strInstructions);

                echo "test ingredient list: ";
                var_dump($testIngredientList);
                echo "test measure list: ";
                var_dump($testMeasureList);
                */

                //primitive tag start
                echo "<tr style='background-color: white;'><td>";

                $strtest = $_SERVER['PHP_SELF'] . "?go";

                //Extract the ingredients from the API and move into array
                $ingredientList = [];
                for ($x = 1; $x <= 20; $x++) {

                    $temp = 'strIngredient' . $x;
                    $strIngr = $meal[$temp];

                    if (!(is_null($strIngr) || empty($strIngr))) {

                        array_push($ingredientList, $strIngr);

                    }

                }
                //print "Below ingredient list:";
                //var_dump($ingredientList);
    
                //adds the measurements to giant string
                $measureList = '';
                for ($i = 1; $i <= 20; $i++) {

                    $tempVar = 'strMeasure' . $i;
                    $strMeasure = $meal[$tempVar];

                    if (!(is_null($strMeasure) || empty($strMeasure))) {

                        $measureList .= ' ' . $strMeasure . ',';
                    }


                }
                /*
                //Add the instructions to a giant string
                $instructionList='';
                for($i=1;$i<=20;$i++){

                  $temp = 'strInstructions'.$i;
                  $strInstruct = $meal[$temp];

                  if(!(is_null($strInstruct) || empty($strInstruct))){
                      $instructionList.=' '.$strInstruct.'';
                  }



                }
                */

                //DATABASE INSERTION
                $message = '';
                //button was clicked checker
                if (isset($_POST['id']) && $_POST['id'] == $idMeal) {

                    try {
                        $json_encode_x = json_encode($ingredientList);

                        //print "Below id meal:";
                        //var_dump($idMeal);
                        // print "instruction list";
                        // var_dump($instructionList);
    

                        /*
                       $strmeal = $meal['strMeal'];
                       $idMeal = $meal['idMeal'];
                       $strInstructions = $meal['strInstructions'];
                       */

                        $sql = "INSERT INTO Recipe (IdMeal,Meal,Instructions,Ingredients,Measurements) VALUES ('$idMeal','$strmeal','$strInstructions','$json_encode_x','$measureList');";

                        //$sql = "SELECT IdMeal, Meal FROM Recipe";
    
                        if (mysqli_query($conn, $sql)) {
                            $message = 'Saved!';
                        }

                        $message = 'Saved!';

                    } catch (Exception $e) {

                        error_log($e->getMessage(), "\n");

                        $message = 'Failed';

                    }

                    mysqli_close($conn);

                }
                //DATABASE INSERTION END
    
                echo
                    "<details " . (isset($_POST['id']) && $_POST['id'] == $idMeal ? 'open' : '') . ">
                    <summary>" . $strmeal . "</summary>
                        <div class='details-content'>          
                            <div style=text-align:right;>
                                    <form action='" . $strtest . "' method='post'>
                                    
                                        <input type='hidden' name='name' value='" . $_POST['name'] . "'>
                                        <input type='hidden' name='id' value='" . $idMeal . "'>
                                        
                                        <div id='buttons_panel'>
                                            " . get_buttons() . "
                                            " . $message . "
                                        </div>
                                    </form>
                             </div>
                             <strong>Preparation Instructions</strong>: " . $strInstructions . "
                             <br>
                             <br>
                             <strong>Ingredients</strong>: " . implode(',', $ingredientList) . "
                             <br>
                             <br>
                             <strong>Measurements</strong>: " . $measureList . "
                             </div>
                  </details>";

                //primitive tag ends
                echo "</td></tr>";

            }

            echo "</table>";

            //everything has been listed at this point.
    
        }
    }


    ?>
    
</body>

<footer>
    <div class="footer">

    <a href="index.php">Back</a>

    </div>


</footer>

</html>