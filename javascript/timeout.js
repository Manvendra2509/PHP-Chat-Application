// Timeout duration in seconds (18000 seconds = 3 minutes)
var inactivityTimeout = 18000;

// Variable to store the timer reference
var timer;

// Function to reset the timer
function resetTimer() {
  // Clear any existing timeout
  clearTimeout(timer);
  // Set a new timeout to call the logout function after the specified duration
  timer = setTimeout(logout, inactivityTimeout * 1000);
}

// Function to handle logout
function logout() {
  // Redirect the user to the "php/logout.php" file to perform the logout action
  window.location.href = "php/logout.php";
}

// Attach event listeners to track user activity and reset the timer on activity
document.addEventListener("mousemove", resetTimer);
document.addEventListener("mousedown", resetTimer);
document.addEventListener("keypress", resetTimer);
document.addEventListener("touchmove", resetTimer);

// Initial setup on page load to start the timer
resetTimer();
