
var inactivityTimeout = 18000; // Timeout in seconds (3 minutes)
var timer;

// Function to reset the timer
function resetTimer() {
    clearTimeout(timer);
    timer = setTimeout(logout, inactivityTimeout * 1000);
}

// Function to handle logout
function logout() {
    window.location.href = "php/logout.php?logout_id=" + uniqueId;
}

// Attach event listeners to track user activity
document.addEventListener("mousemove", resetTimer);
document.addEventListener("mousedown", resetTimer);
document.addEventListener("keypress", resetTimer);
document.addEventListener("touchmove", resetTimer);

// Initial setup on page load
resetTimer();
