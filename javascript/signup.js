// Select the form, continue button, and error text element using DOM queries
const form = document.querySelector(".signup form");
const continueBtn = form.querySelector(".button input");
const errorText = form.querySelector(".error-text");
const toastLiveExample = document.getElementById('liveToast');
const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);

// Prevent the form from submitting in the traditional way (page reload)
form.onsubmit = (e) => {
  e.preventDefault();
};

// Add a click event listener to the continue button
continueBtn.onclick = () => {
  // Create an XMLHttpRequest object to make an AJAX request
  let xhr = new XMLHttpRequest();

  // Configure the AJAX request with the POST method and the target PHP file for signup processing
  xhr.open("POST", "php/signup.php", true);

  // Define the event handler for when the AJAX request is completed
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Get the response data from the server
        let data = xhr.response;
        if (data === "success") {
          errorText.style.display = "none";          
          toastBootstrap.show();
          form.reset();
        } else {
          // If the response is an error message, display it in the error text element
          errorText.style.display = "block";
          errorText.textContent = data;
          alertSuccess.style.display = "none"
        }
      }
    }
  };

  // Create a FormData object to collect the input data from the form
  let formData = new FormData(form);

  // Send the form data to the server using the AJAX request
  xhr.send(formData);
};
