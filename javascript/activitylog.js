activityList = document.querySelector(".activity-list");

setInterval(() =>{
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "php/activity_log.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
            activityList.innerHTML = data;
        }
    }
  }
  xhr.send();
}, 500);

