<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="Resources/styles/college.css">
      <link rel="stylesheet" href="Resources/styles/search.css">
      <script src="https://developer.edamam.com/attribution/badge.js"></script>
      <title>College Corner</title>
   </head>
   
   
   <body>
      <nav>
         <a href="index.html"><img src="Resources/images/logo.png" alt="Home" width="150" height="150" id = "logo"></a>
           <ul>
              <li><a href="index.html">Home</a></li>
              <li><a href="recipeoftheday.php">Recipe of the Day</a></li>
              <li><a href="#" class = "currentPage">College Corner</a></li>
              <li><a href="parentsplace.php">Parents' Place</a></li>
              <li><a href="allergy.php">Allergy-Friendly</a></li>
              <li><a href="backend/feedback.php">Contact/Feedback</a></li>
           </ul>
           <div class="search-bar">
            <form method="post" action="backend/search.php">
               <input type="text" placeholder="Search..." name="query">
               <button type="submit">Search</button>
            </form>
          </div>
        </nav>
        <!--search bar-->
        
      <h1 id="title">College Corner</h1>
      <h2 id="slogan">Quick Recipes For<br>Dinners In A Pinch</h2>
      <div id="edamam-badge" data-color="white"></div>
   </body>
</html>

<?php
  include 'backend/keys.php';

  $url = "https://api.edamam.com/api/recipes/v2?type=public&app_id=".urlencode($APP_ID)."&app_key=".urlencode($API_KEY)."&mealType=Dinner&dishType=Main%20course&dishType=Sandwiches&time=3-10";
  
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

  $recipes = array();
  $recipes_url = array();
  $image_url = array();
  $time = array();

  // Display the recipe titles
  foreach ($data["hits"] as $hit) {
      $title = $hit["recipe"]["label"];

    // Dont add if title is greater than 75 characters
    if (strlen($title) > 75) {
      continue;
    }

      // Go through the recipe, and if it is not already in the array, add it
      // This is done to remove duplicate recipes. Also add that recipe data for 
      // future use
      if (!in_array($title, $recipes)) {
        array_push($recipes, $title);
        array_push($recipes_url, $hit["recipe"]["url"]);
        array_push($image_url, $hit["recipe"]["image"]);
        array_push($time, $hit["recipe"]["totalTime"]);
      }
  }

  for ($i = 0; $i < 2; $i++) {
    
    // Get a random recipe from the array
    $rand_int = rand(10, count($recipes) - 1);

    // Make sure the random recipe is not the same as the previous one
    if ($rand_int == $prev_index) {
      $rand_int = rand(10, count($recipes) - 1);
    } 

    // The second recipe should be on the left of the first
    if ($i == 0) {
      echo "<div id='containerSecond'>";
      echo "<a href=" . $recipes_url[$rand_int] . " target='_blank' id='recipeText'>" . $recipes[$rand_int] . "</a><br>";
      echo"<a href=" . $recipes_url[$rand_int] . " target='_blank'><img src=" . $image_url[$rand_int] . " alt='Recipe Image' width='200' height='200' id='otherRecipeimg'></a><br>";
      echo "</div>";
    }

    // The third one should be on the right side
    else {
      echo "<div id='containerThird'>";
      echo "<a href=" . $recipes_url[$rand_int] . " target='_blank' id=recipeText>" . $recipes[$rand_int] . "</a><br>";
      echo "<a href=" . $recipes_url[$rand_int] . " target='_blank'><img src=" . $image_url[$rand_int] . " alt='Recipe Image' width='200' height='200' id='otherRecipeimg'></a><br>";
      echo "</div>";
    }

    $prev_index = $rand_int;
  }
  
    
?>