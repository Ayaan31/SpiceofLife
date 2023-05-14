<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="Resources/styles/allergy.css">
      <link rel="stylesheet" href="Resources/styles/search.css">
      <script src="https://developer.edamam.com/attribution/badge.js"></script>
      <title>Allergy Friendly</title>
   </head>
   
   <body>
   <!--search bar-->
    <nav>
      <a href="index.html"><img src="Resources/images/logo.png" alt="Home" width="150" height="150" id = "logo"></a>
        <ul>
           <li><a href="index.html">Home</a></li>
           <li><a href="recipeoftheday.php">Recipe of the Day</a></li>
           <li><a href="collegecorner.php">College Corner</a></li>
           <li><a href="parentsplace.php">Parents' Place</a></li>
           <li><a href="#" class = "currentPage">Allergy-Friendly</a></li>
           <li><a href="backend/feedback.php">Contact/Feedback</a></li>
        </ul>
        <div class="search-bar">

         <!-- Send post requst to recipe seach php file -->
         <form method="post" action="backend/search.php">
            <input type="text" placeholder="Search..." name="query">
            <button type="submit">Search</button>
         </form>
       </div>
      </nav>
      <h1 id="title">Allergy Friendly</h1>
      <h2 id="slogan">Food To Fit<br>Your Diet</h2>
      <div id="edamam-badge" data-color="white"></div>
   </body>
</html>

<?php

   // Get needed keys
   include 'backend/keys.php';
   
   $recipes = array();
   $recipes_url = array();
   $image_url = array();
   
   $index = 5;
   for ($i=0; $i < 2; $i++) {
      
      // Get a dairy free and also a gluten free recipe
      if ($i == 0) {
         $url = "https://api.edamam.com/api/recipes/v2?type=public&app_id=".urlencode($APP_ID)."&app_key=".urlencode($API_KEY)."&health=alcohol-free&health=dairy-free&mealType=Dinner&dishType=Main%20course&dishType=Sandwiches";
         $index = 13;
      }
      else {
         $url = "https://api.edamam.com/api/recipes/v2?type=public&app_id=".urlencode($APP_ID)."&app_key=".urlencode($API_KEY)."&health=alcohol-free&health=gluten-free&mealType=Dinner&dishType=Main%20course&dishType=Sandwiches";
         $index = 18;
      }

      // Intialize a curl instance 
      $ch = curl_init($url);

      // Return the reponse from the EDAMAM API and store it
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($ch);

      // Close the curl session
      curl_close($ch);

      // Since the response comes back as JSON, we can use this 
      // builtin PHP function 
      $data = json_decode($response, true);
   
      $title = $data["hits"][$index]["recipe"]["label"];
      array_push($recipes, $title);
      array_push($recipes_url, $data["hits"][$index]["recipe"]["url"]);
      array_push($image_url, $data["hits"][$index]["recipe"]["image"]);
   }

  // Printing out two random recipes from the array
  for ($i = 0; $i < 2; $i++) {

    // The second recipe should be on the left of the first
    if ($i == 0) {
        echo "<div id='containerSecond'>";
        echo "<a href=" . $recipes_url[$i] . " target='_blank' id='recipeText'>" . $recipes[$i] . "</a><br>";
        echo"<a href=" . $recipes_url[$i] . " target='_blank'><img src=" . $image_url[$i] . " alt='Recipe Image' width='200' height='200' id='otherRecipeimg'></a><br>";
        echo '<p> Health Labels: '. $data["hits"][13]["recipe"]["healthLabels"][7]. '</p>';
        echo "</div>";
    }

    // The third one should be on the right side
    else {
        echo "<div id='containerThird'>";
        echo "<a href=" . $recipes_url[$i] . " target='_blank' id=recipeText>" . $recipes[$i] . "</a><br>";
        echo "<a href=" . $recipes_url[$i] . " target='_blank'><img src=" . $image_url[$i] . " alt='Recipe Image' width='200' height='200' id='otherRecipeimg'></a><br>";
        echo '<p> Health Labels: '. $data["hits"][18]["recipe"]["healthLabels"][5]. '</p>';
        echo "</div>";
    }

  }
?>