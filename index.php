<html>

<head>

    <meta charset="UTF-8">
    <title>Food Store View</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h1>Receipe Search</h1>

    <p>Please specify a keyword to search the popular receipe site <a href="https://www.themealdb.com/"
            target="_blank">www.TheMealDB.com</a>

        <br><br>(TheMealDB is a site for learning and cooking new receipies from different cultures around the world)
    </p>

    <p>Friendly suggestions: Vegan, Cake, Pickles,Chicken..</p>

    <!-- post - data is submitted to be processed to a specific resource -->
    <form action="search_submit.php?go" id="searchform" method="post">

        <!--        The search box area in html-->
        <input name="name" placeholder="Search.." type="text" />

        <!-- this is what processes it, the submit button-->
        <input name="submit" type="submit" value="Search" />

    </form>
    <br>

    <div class="container">
        <h4>Recent Saved Receipes</h4>

        <?php
        // PHP code starts here
        include 'connect.php';

        $sql = "SELECT IdMeal, Meal FROM Recipe";

        $result = mysqli_query($conn,$sql);

        if (mysqli_query($conn, $sql)) {

            //echo "Connection successful";

            if (mysqli_num_rows($result) > 0){

                echo "Total rows: ". mysqli_num_rows($result);

                echo "<br>";

                while($row = mysqli_fetch_assoc($result)){
                    echo "Meal Id: ". $row["IdMeal"].". Meal name: ".$row["Meal"]."<br>";
                }

            } else {
                echo "0 results";
            }
        }

        ?>
        
    </div>

    <footer>
        <div class="footer">
        <img src="tomato.png" alt="footer logo" style="width: 100px;height: 100px;">
        <p>&copy; 2025 Michael Amay Portfolio</p>
        </div>
    </footer>
</body>
</html>