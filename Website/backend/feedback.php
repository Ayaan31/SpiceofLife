<!-- This file contains the Front End for the contact page -->
<!-- And also backend for form submission -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../Resources/styles/contact.css">
  <script type="text/javascript" src="../Resources/scripts/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="../Resources/scripts/contactForm.js"></script>
  <script src="https://developer.edamam.com/attribution/badge.js"></script>
  <title>Feedback</title>
</head>

<body>
  <nav>
      <a href="../index.html"><img src="../Resources/images/logo.png" alt="Home" width="150" height="150" id = "logo"></a>
        <ul>
          <li><a href="../index.html">Home</a></li>
          <li><a href="../recipeoftheday.php">Recipe of the Day</a></li>
          <li><a href="../collegecorner.php">College Corner</a></li>
          <li><a href="../parentsplace.php">Parents' Place</a></li>
          <li><a href="../allergy.php">Allergy-Friendly</a></li>
          <li><a href="#" class = "currentPage">Contact/Feedback</a></li>
        </ul>
        <div class="search-bar">
        <form method="post" action="search.php">
            <input type="text" placeholder="Search..." name="query">
            <button type="submit">Search</button>
        </form>
      </div>
    </nav>
    <!--search bar-->
    
  <h1 id="title">Submit Feedback</h1>
  <div id = "formBlock">
      <form id="contactForm" name="contactForm" action="feedback.php" method="post" onsubmit="return validate(this);">
        <fieldset>
            <legend>Contact Information</legend>
            <div class="formData">

              <label for = "firstName" class="field">First Name:</label>
              <div class="value"><input type="text" size="60" value="" name="firstName" id="firstName" autofocus/></div>

              <label for = "lastName" class="field">Last Name:</label>
              <div class="value"><input type="text" size="60" value="" name="lastName" id="lastName" /></div>

              <label for = "email" class="field">Email:</label>
              <div class="value"><input type="text" size="60" value="" name="email" id="email" /></div>

              <label for = "message" class="field">Message:</label>
              <div class="value"><textarea rows="4" cols="40" name="message"
                    id="message" onfocus = "return clearText(this);" onblur = "return resetText(this);">Please enter your message</textarea></div>
              
              
              <input type="submit" value="Submit" id="save" name="save" />
            </div>
        </fieldset>
      </form>
  </div>
  <div id="edamam-badge" data-color="white"></div>
</body>

<?php

$dbOK = false;

// DO NOT DO THIS IN PRODUCTION CODE
@ $db = new mysqli('localhost', 'root', 'root', 'feedback');


if ($db->connect_error) {
  echo '<div>502 BAD GATEWAY: Could not connect to the database. Error:';
  echo $db->connect_errno . ' - ' . $db->connect_error . '</div>';
} 
else {
  $dbOK = true;
}

  $havePost = isset($_POST["save"]);
  
  // Trim the input
  $first_name = htmlspecialchars(trim($_POST["firstName"]));
  $last_name = htmlspecialchars(trim($_POST["lastName"]));
  $email = htmlspecialchars(trim($_POST["email"]));

  // For this, characters like apostrophes would show up as its HTML entity code
  // So we need to decode it
  $message = html_entity_decode(htmlspecialchars(trim($_POST['message'])));
  
  // Backend error checking
  if ($havePost) {

    if ($first_name == '') {
      $errors .= '<li>First name may not be blank</li>';
      
    }
    if ($last_name == '') {
      $errors .= '<li>Last name may not be blank</li>';
    }

    if ($email == '') {
      $errors .= '<li>Email may not be blank</li>'; 
    }

    if ($message == '') {
      $errors .= '<li>Message may not be blank</li>';
    }

    if ($errors != '') {
      echo '<div class="messages"><h4>Please correct the following errors:</h4><ul>';
      echo $errors;
      echo '</ul></div>';
    } 
  }

  // Insert into database if connected to DB, form was submitted, and no errors
  if ($dbOK and $havePost and $errors == '') {

    // Sanitize the input
    $query = "INSERT INTO Feedback (`First Name`, `Last Name`, `Email`, `Message`) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $message);
    $stmt->execute();
    $stmt->close();
    echo '<div class="messages">Thank you for your feedback!</div>';
  }

  $db->close();

?>