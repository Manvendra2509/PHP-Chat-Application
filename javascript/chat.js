const form = document.querySelector(".typing-area"),
incoming_id = form.querySelector(".incoming_id").value,
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
form.onsubmit = (e)=>{
    e.preventDefault();
}

inputField.focus();
inputField.onkeyup = ()=>{
    if(inputField.value != ""){
        sendBtn.classList.add("active");
    }else{
        sendBtn.classList.remove("active");
    }
}

// Emoji Panel Code Start
const emojiSelectorIcon = document.getElementById('emojiSelectorIcon');
const emojiSelector = document.getElementById('emojiSelector');
const emojiList = document.getElementById('emojiList');
const emojiSearch = document.getElementById('emojiSearch');
const inputArea = document.getElementById('message-box');
const emojiSelectorIconSVG = document.getElementById('emojiSelectorIconSVG');

emojiSelectorIcon.addEventListener('click', () => {
   emojiSelector.classList.toggle('active');
});

fetch('https://emoji-api.com/emojis?access_key=26ee84451124936ee167c73b26aaa6eb92493485')
   .then(res => res.json())
   .then(data => loadEmoji(data))

function loadEmoji(data) {
   data.forEach(emoji => {
       let li = document.createElement('li');
       li.setAttribute('emoji-name', emoji.slug);
       li.textContent = emoji.character;
       li.addEventListener('click', () => {
        inputArea.value += emoji.character;
    });
       emojiList.appendChild(li);
   });
}

emojiSearch.addEventListener('keyup', e => {
    let value = e.target.value.toLowerCase();
    let emojis = document.querySelectorAll('#emojiList li');
    emojis.forEach(emoji => {
        const emojiName = emoji.getAttribute('emoji-name').toLowerCase();
        if (emojiName.includes(value)) {
            emoji.style.display = 'flex';
        } else {
            emoji.style.display = 'none';
        } 
    });
});


document.addEventListener('mousedown', (event) => {
    const target = event.target;
    console.log(event.target);
    if (!emojiSelector.contains(target) && target !== emojiSelectorIcon && target !== emojiSelectorIconSVG) {
        emojiSelector.classList.remove('active');
    }
});
//Emoji Panel Code End

sendBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              inputField.value = "";
              scrollToBottom();
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}
chatBox.onmouseenter = ()=>{
    chatBox.classList.add("active");
}

chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active");
}

setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            chatBox.innerHTML = data;
            if(!chatBox.classList.contains("active")){
                scrollToBottom();
              }
          }
      }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("incoming_id="+incoming_id);
}, 500);

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
  }
  