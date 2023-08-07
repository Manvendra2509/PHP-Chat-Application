// Select the form, continue button, and error text elements in the DOM
const form = document.querySelector(".signup form"),
  continueBtn = form.querySelector(".button input"),
  errorText = form.querySelector(".error-text");

// Prevent the default form submission when the user clicks the submit button
form.onsubmit = (e) => {
  e.preventDefault();
};

// Event listener for the continue button (submit button)
continueBtn.onclick = () => {
  // Create a new XMLHttpRequest object
  let xhr = new XMLHttpRequest();
  // Open a POST request to the "php/update-profile.php" file for processing
  xhr.open("POST", "php/update-profile.php", true);
  // Function to execute when the request has completed successfully
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      // Check if the response status is 200 (success)
      if (xhr.status === 200) {
        // Get the response data from the server
        let data = xhr.response;
        // If the server response is "success", redirect to "users.php"
        if (data === "success") {
          location.href = "users.php";
        } else {
          // If the server response is not "success", display the error text
          errorText.style.display = "block";
          errorText.textContent = data;
        }
      }
    }
  };
  // Create a new FormData object from the form, including the input data
  let formData = new FormData(form);
  // Send the form data to the server for processing
  xhr.send(formData);
};
