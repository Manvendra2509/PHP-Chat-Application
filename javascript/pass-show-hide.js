// Get the password input field and the toggle icon (an icon to switch between showing and hiding the password)
const pswrdField = document.querySelector(".form input[type='password']"),
      toggleIcon = document.querySelector(".form .field i");

// Handle the click event on the toggle icon
toggleIcon.onclick = () => {
    // Check the current type of the password input field
    if (pswrdField.type === "password") {
        // If the password input field is of type "password", change it to "text"
        pswrdField.type = "text";

        // Add the "active" class to the toggle icon to visually indicate that the password is visible
        toggleIcon.classList.add("active");
    } else {
        // If the password input field is already of type "text", change it back to "password"
        pswrdField.type = "password";

        // Remove the "active" class from the toggle icon to visually indicate that the password is hidden
        toggleIcon.classList.remove("active");
    }
}
