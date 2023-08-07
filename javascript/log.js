// Get the search bar, search icon, and the list of users
const searchBar = document.querySelector(".search input"),
  searchIcon = document.querySelector(".search button"),
  usersList = document.querySelector(".users-list");

// Event listener for the search icon click
searchIcon.onclick = () => {
  // Toggle the visibility of the search bar
  searchBar.classList.toggle("show");
  // Toggle the active state of the search icon
  searchIcon.classList.toggle("active");
  // Focus on the search bar to enable typing immediately
  searchBar.focus();
  // Clear the search bar value when toggling off the search bar
  if (searchBar.classList.contains("active")) {
    searchBar.value = "";
    searchBar.classList.remove("active");
  }
};

// Event listener for keyup in the search bar
searchBar.onkeyup = () => {
  // Get the search term from the search bar
  let searchTerm = searchBar.value;
  // Add or remove the "active" class based on whether the search bar has content
  if (searchTerm != "") {
    searchBar.classList.add("active");
  } else {
    searchBar.classList.remove("active");
  }

  // Create a new XMLHttpRequest to make a POST request to the "search.php" file
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/search.php", true);
  xhr.onload = () => {
    // Check if the XMLHttpRequest is done and the status is 200 (OK)
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      // Get the response data from the server
      let data = xhr.response;
      // Update the users list with the search results
      usersList.innerHTML = data;
    }
  };
  // Set the request header for POST data
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  // Send the search term as POST data to "search.php"
  xhr.send("searchTerm=" + searchTerm);
};

// Set an interval to fetch the user activity log every 500 milliseconds
setInterval(() => {
  // Create a new XMLHttpRequest to make a GET request to the "log.php" file
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "php/log.php", true);
  xhr.onload = () => {
    // Check if the XMLHttpRequest is done and the status is 200 (OK)
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      // Get the response data from the server
      let data = xhr.response;
      // Update the users list with the activity log data if the search bar is not active
      if (!searchBar.classList.contains("active")) {
        usersList.innerHTML = data;
      }
    }
  };
  // Send the GET request to fetch the user activity log
  xhr.send();
}, 500);
