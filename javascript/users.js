// Get references to the DOM elements
const searchBar = document.querySelector(".search input");
const searchIcon = document.querySelector(".search button");
const usersList = document.querySelector(".users-list");

// Handle the click event on the search icon
searchIcon.onclick = () => {
  // Toggle the 'show' class on the search bar to display/hide it
  searchBar.classList.toggle("show");

  // Toggle the 'active' class on the search icon to change its appearance
  searchIcon.classList.toggle("active");

  // Set focus on the search bar for user input
  searchBar.focus();

  // Clear the search bar's value if it has the 'active' class
  if (searchBar.classList.contains("active")) {
    searchBar.value = "";
    searchBar.classList.remove("active");
  }
};

// Handle the keyup event on the search bar
searchBar.onkeyup = () => {
  // Get the current search term from the search bar's value
  let searchTerm = searchBar.value;

  // Add or remove the 'active' class on the search bar based on whether there's a search term or not
  if (searchTerm != "") {
    searchBar.classList.add("active");
  } else {
    searchBar.classList.remove("active");
  }

  // Create a new XMLHttpRequest object to send an AJAX request to search for users
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/search.php", true);

  // Define what to do when the response is received
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;

        // Update the 'usersList' element with the data received from the server
        usersList.innerHTML = data;
      }
    }
  };

  // Set the request header for sending form data
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  // Send the search term as form data to the 'search.php' file on the server
  xhr.send("searchTerm=" + searchTerm);
};

// Periodically update the user list to show the latest users without search term
setInterval(() => {
  // Create a new XMLHttpRequest object to send an AJAX request to get the latest users
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "php/users.php", true);

  // Define what to do when the response is received
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;

        // Update the 'usersList' element with the data received from the server
        if (!searchBar.classList.contains("active")) {
          usersList.innerHTML = data;
        }
      }
    }
  };

  // Send the request to the server to get the latest users
  xhr.send();
}, 500); // Refresh every 500 milliseconds (0.5 seconds) to keep the user list updated
