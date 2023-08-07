const form = document.querySelector(".signup form");
const continueBtn = form.querySelector(".button input");
const errorText = form.querySelector(".error-text");

// Prevent the default form submission behavior when the form is submitted
form.onsubmit = (e) => {
  e.preventDefault();
};

// Attach a click event to the "Continue" button (submit button)
continueBtn.onclick = () => {
  // Create a new XMLHttpRequest object
  let xhr = new XMLHttpRequest();
  
  // Prepare the AJAX POST request to the "php/update-homepage.php" endpoint
  xhr.open("POST", "php/update-homepage.php", true);
  
  // Define the function to be executed when the AJAX request is complete
  xhr.onload = () => {
    // Check if the AJAX request is in the "DONE" state
    if (xhr.readyState === XMLHttpRequest.DONE) {
      // Check if the status code of the response is 200 (OK)
      if (xhr.status === 200) {
        // Get the response data from the server
        let data = xhr.response;
        // Check if the response data is "success"
        if (data === "success") {
          // If the response is "success", redirect the user to "users.php" page
          location.href = "users.php";
        } else {
          // If the response is not "success", display the error text on the page
          errorText.style.display = "block";
          errorText.textContent = data;
        }
      }
    }
  };
  
  // Create a new FormData object containing the form data
  let formData = new FormData(form);
  
  // Send the AJAX request with the form data
  xhr.send(formData);
};
