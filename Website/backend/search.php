<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../Resources/styles/index.css">
  <link rel="stylesheet" href="../Resources/styles/search.css">
  <script src="https://developer.edamam.com/attribution/badge.js"></script>
  <title>Recipes</title>
</head>
   
<body>
 <!--search bar-->
 <nav>
  <a href="../index.html"><img src="../Resources/images/logo.png" alt="Home" width="150" height="150" id = "logo"></a>
    <ul>
      <li><a href="../index.html">Home</a></li>
      <li><a href="../recipeoftheday.php">Recipe of the Day</a></li>
      <li><a href="../collegecorner.php">College Corner</a></li>
      <li><a href="../parentsplace.php">Parents' Place</a></li>
      <li><a href="../allergy.php">Allergy-Friendly</a></li>
      <li><a href="feedback.php">Contact/Feedback</a></li>
    </ul>
    <div class="search-bar">

      <!-- Send post requst to recipe seach php file -->
      <form method="post" action="search.php">
        <input type="text" placeholder="Search..." name="query">
        <button type="submit">Search</button>
      </form>
    </div>
  </nav>
  <div id="edamam-badge" data-color="white"></div>
</body>

<?php

// Get needed keys
include 'keys.php';

// This will run whe
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $recipe = $_POST["query"];
  $recipe = strip_tags($recipe);
  $url = "https://api.edamam.com/search?q=".urlencode($recipe)."&app_id=".urldecode($APP_ID)."&app_key=".urlencode($API_KEY);
  
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

  // Return error if no recipe is returned
  if ($data["count"] == 0) {
    echo "No such recipes for" . $recipe . "<br>";
    exit();
  }
  
  $recipes = array();
  $recipes_url = array();
  $image_url = array();

  // Display the recipe titles
  foreach ($data["hits"] as $hit) {
      $title = $hit["recipe"]["label"];

      // Go through the recipe, and if it is not already in the array, add it
      // This is done to remove duplicate recipes. Also add that recipe data for 
      // future use
      if (!in_array($title, $recipes)) {
        array_push($recipes, $title);
        array_push($recipes_url, $hit["recipe"]["url"]);
        array_push($image_url, $hit["recipe"]["image"]);
      }

  }

  // Display the top three recipes
  for ($i = 0; $i < count($recipes) and $i < 3; $i++) {

    // This is the top recipe, so we want put emphasis on this
    if ($i == 0) {
      echo "<div id='container'>";
      echo "<a href=" . $recipes_url[$i] . " target='_blank' id='recipeText'>" . $recipes[$i] . "</a><br>";
      echo "<a href=" . $recipes_url[$i] . " target='_blank'> <img src=" . $image_url[$i] . " alt='Recipe Image' width='200' height='200' id='mainRecipeimg'></a><br>";
      echo "</div>";
    }

    // The second recipe should be on the left of the first
    else if ($i == 1) {
      echo "<div id='containerSecond'>";
      echo "<a href=" . $recipes_url[$i] . " target='_blank' id='recipeText'>" . $recipes[$i] . "</a><br>";
      echo"<a href=" . $recipes_url[$i] . " target='_blank'><img src=" . $image_url[$i] . " alt='Recipe Image' width='200' height='200' id='otherRecipeimg'></a><br>";
      echo "</div>";
    }

    // The third one should be on the right side
    else {
      echo "<div id='containerThird'>";
      echo "<a href=" . $recipes_url[$i] . " target='_blank' id=recipeText>" . $recipes[$i] . "</a><br>";
      echo "<a href=" . $recipes_url[$i] . " target='_blank'><img src=" . $image_url[$i] . " alt='Recipe Image' width='200' height='200' id='otherRecipeimg'></a><br>";
      echo "</div>";
    }
    
  }
  // EASTER EGG??? :)
  // YOU'RE TELLING ME A SHRIMP FRIED THIS RICE!
  if ($recipe == "Shrimp Fried Rice") {
    echo "<a href='https://preview.redd.it/youre-telling-me-a-shrimp-fried-this-rice-v0-s1foj8r891981.jpg?auto=webp&s=77870b4842087ea433174eb84869e385910bb1d2' target='_blank'>BONUS!</a>";
  }

}


?>
