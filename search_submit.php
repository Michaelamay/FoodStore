<html>
<head>
    <!--    CSS-->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
<!--    <h3><a href="SaveList.php">Saved List</a></h3>-->
    
    <?php
    
    
    function get_buttons(){
        
        $str='&nbsp;<input type="submit" value="Save recipie" name="btn" id="btn"/>';
        
        return $str;
    }
    
    //test function
    function click_checker(){
        
        $click ='Clicked!';
        //check clicked button
        if(isset($_POST['btn'])){
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
          
          $url = "https://www.themealdb.com/api/json/v1/1/search.php?f=".$firstLetter;
                  
          $curl = curl_init($url);
          curl_setopt($curl, CURLOPT_URL, $url);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          
          $resp = curl_exec($curl);
          curl_close($curl);
                            
          $decoded_json = json_decode($resp,true);
          
          $meals = $decoded_json['meals'];
          
          echo "<table border= '1px';>";
          
          foreach($meals as $meal){
              
              $strmeal = $meal['strMeal'];
              $idMeal = $meal['idMeal'];
              $strInstructions = $meal['strInstructions'];
              
              //primitive tag start
              echo "<tr style='background-color: white;'><td>";
                  
              $strtest = $_SERVER['PHP_SELF']."?go";
              
              
              //Extract the ingredients from the API and move into array
              $ingredientList =[];
              for($x=1;$x <= 20; $x++){
                  
                  $temp = 'strIngredient'.$x;
                  $strIngr = $meal[$temp];
                  
                  if(!(is_null($strIngr) || empty($strIngr))){
                      
                      array_push($ingredientList , $strIngr);
                      
                  }
                  
              }
              //var_dump($ingredientList);
              
              //adds the measurements to giant string
              $measureList='';
              for($i=1;$i<=20;$i++){
                  
                  $tempVar = 'strMeasure'.$i;
                  $strMeasure = $meal[$tempVar];
                  
                  if(!(is_null($strMeasure) || empty($strMeasure))){
                      
                      $measureList.= ' '.$strMeasure.',';
                  }
                  
                  
              }
              
              //DATABASE INSERTION
              $message = '';
              //button was clicked checker
              if(isset($_POST['id']) && $_POST['id'] == $idMeal) {
                 
                  //Insert into the table, we have a placeholder for the variable ingredients for now. Commas separate the columns only.
                  $sqlInsertion = "INSERT INTO Recipe(IdMeal,Meal,Instructions,Ingredients,Measurements)  
                          VALUES('".$idMeal."','".$strmeal."','".$strInstructions."',?,'".$measureList."')";
                  
                  //Create/open the connection to MySQL
                  $query = $conn->prepare($sqlInsertion);
                  
                  //The ingredientList is stored in a json format from an array. We modified the query.
                  $query->bind_param('s', json_encode($ingredientList));
                  
                  //finally execute the query
                  $res = $query->execute();
                  
                  //check if query was successful and display confirmation on screen for client
                  if($res== TRUE) {
                      $message = 'saved!';
                  }
                  
                  
              }
              //DATABASE INSERTION END
              
              echo 
                  "<details ".(isset($_POST['id']) && $_POST['id'] == $idMeal ? 'open' : '').">
                    <summary>".$strmeal."</summary>
                        <div class='details-content'>          
                            <div style=text-align:right;>
                                    <form action='".$strtest."' method='post'>
                                    
                                        <input type='hidden' name='name' value='".$_POST['name']."'>
                                        <input type='hidden' name='id' value='".$idMeal."'>
                                        
                                        <div id='buttons_panel'>
                                            ".get_buttons()."
                                            ".$message."
                                        </div>
                                    </form>
                             </div>
                             <strong>Preparation Instructions</strong>: ".$strInstructions."
                             <br>
                             <br>
                             <strong>Ingredients</strong>: ".implode(',', $ingredientList)."
                             <br>
                             <br>
                             <strong>Measurements</strong>: ".$measureList."
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

</html>