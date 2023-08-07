// Get the DOM element with class "activity-list"
activityList = document.querySelector(".activity-list");

// Function to fetch activity log data using AJAX
function activityData(){
  // Create a new XMLHttpRequest object
  let xhr = new XMLHttpRequest();
  
  // Set the HTTP method, URL for fetching activity log data, and make it asynchronous (true)
  xhr.open("GET", "php/activity_log.php", true);
  
  // Function to handle the response when the request is completed
  xhr.onload = ()=>{
    // Check if the request's state is DONE and the status is OK (200)
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
      // Get the response data from the server
      let data = xhr.response;
      
      // Populate the activityList element's innerHTML with the received data (activity log)
      activityList.innerHTML = data;
    }
  };
  
  // Send the AJAX request to fetch activity log data
  xhr.send();
}

// Call the activityData function to fetch and display the activity log on page load
activityData();
