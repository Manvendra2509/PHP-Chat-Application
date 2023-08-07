// Get the login form, the 'Continue' button, and the error text element from the DOM
const form = document.querySelector(".login form"),
      continueBtn = form.querySelector(".button input"),
      errorText = form.querySelector(".error-text");

// Prevent the default form submission behavior
form.onsubmit = (e) => {
    e.preventDefault();
}

// Handle the 'Continue' button click event
continueBtn.onclick = () => {
    // Create a new XMLHttpRequest object to send an AJAX request
    let xhr = new XMLHttpRequest();

    // Set up the request to send data to the "php/login.php" URL using the POST method
    xhr.open("POST", "php/login.php", true);

    // Define what to do when the response is received
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            // Check if the response status is successful (status code 200)
            if (xhr.status === 200) {
                // Parse the response data received from the server
                let data = xhr.response;

                // Check if the login was successful (the server returned "success")
                if (data === "User added!") {
                    // If login is successful, redirect the user to the "users.php" page
                    successText.style.display = "block";
                    successText.style.textContent = data;
                } else {
                    // If login failed, display the error message returned from the server
                    errorText.style.display = "block";
                    errorText.textContent = data;
                }
            }
        }
    };

    // Get the form data and send it with the AJAX request
    let formData = new FormData(form);
    xhr.send(formData);
}
