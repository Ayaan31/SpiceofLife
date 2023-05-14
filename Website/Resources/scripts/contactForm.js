//function to validate the contents of the form
function validate(formObj) {
   // put your validation code here
   // it will be a series of if statements
   var errors = []; 
   if (formObj.firstName.value == "") {
      errors.push("You must enter a first name");
      formObj.firstName.focus();
   }
   if (formObj.lastName.value == "") {
      errors.push("You must enter a last name");
      formObj.lastName.focus();
   }
   if (formObj.email.value == "") {
      errors.push("You must enter an email address");
      formObj.email.focus();
   }
   if (formObj.message.value == "" || formObj.message.value == "Please enter your message") {
      errors.push("You must enter a message");
      formObj.message.focus();
   }
   

   if(errors.length > 0) {
      alert(errors.join("\n"));
      return false;
   }
   processData();
   return true;
}
//create function to get data from form
function getData() {
      //create variable to store data
      var data = {};
      //get data from form
      data.firstName = document.getElementById("firstName").value;
      data.lastName = document.getElementById("lastName").value;
      data.email = document.getElementById("email").value;
      data.message = document.getElementById("message").value;
      //return data
      return data;
}

function clearText(formObj) {
   if(document.getElementById('message').value == "Please enter your message"){
      document.getElementById('message').value = "";
   }
}
function resetText(formObj) {
   if(document.getElementById('message').value == ""){      
      document.getElementById('message').value = "Please enter your message";
   }
}
