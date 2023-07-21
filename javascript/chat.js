const form = document.querySelector(".typing-area"),
  incoming_id = form.querySelector(".incoming_id").value,
  inputField = form.querySelector(".input-field"),
  sendBtn = form.querySelector(".send-button"),
  chatBox = document.querySelector(".chat-box");
const tooltipTriggerList = document.querySelectorAll(
  '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
  (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);
form.onsubmit = (e) => {
  e.preventDefault();
};

inputField.focus();
inputField.onkeyup = () => {
  if (inputField.value != "") {
    sendBtn.classList.add("active");
  } else {
    sendBtn.classList.remove("active");
  }
};

// Emoji Panel Code Start
const emojiSelectorIcon = document.getElementById("emojiSelectorIcon");
const emojiSelector = document.getElementById("emojiSelector");
const emojiList = document.getElementById("emojiList");
const emojiSearch = document.getElementById("emojiSearch");
const inputArea = document.getElementById("message-box");
const emojiSelectorIconSVG = document.getElementById("emojiSelectorIconSVG");

emojiSelectorIcon.addEventListener("click", () => {
  emojiSelector.classList.toggle("active");
});

fetch(
  "https://emoji-api.com/emojis?access_key=26ee84451124936ee167c73b26aaa6eb92493485"
)
  .then((res) => res.json())
  .then((data) => loadEmoji(data));

function loadEmoji(data) {
  data.forEach((emoji) => {
    let li = document.createElement("li");
    li.setAttribute("emoji-name", emoji.slug);
    li.textContent = emoji.character;
    li.addEventListener("click", () => {
      inputArea.value += emoji.character;
    });
    emojiList.appendChild(li);
  });
}

emojiSearch.addEventListener("keyup", (e) => {
  let value = e.target.value.toLowerCase();
  let emojis = document.querySelectorAll("#emojiList li");
  emojis.forEach((emoji) => {
    const emojiName = emoji.getAttribute("emoji-name").toLowerCase();
    if (emojiName.includes(value)) {
      emoji.style.display = "flex";
    } else {
      emoji.style.display = "none";
    }
  });
});

document.addEventListener("mousedown", (event) => {
  const target = event.target;
  console.log(event.target);
  if (
    !emojiSelector.contains(target) &&
    target !== emojiSelectorIcon &&
    target !== emojiSelectorIconSVG
  ) {
    emojiSelector.classList.remove("active");
  }
});
//Emoji Panel Code End

sendBtn.onclick = () => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/insert-chat.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        inputField.value = "";
        scrollToBottom();
      }
    }
  };
  let formData = new FormData(form);
  xhr.send(formData);
};
chatBox.onmouseenter = () => {
  chatBox.classList.add("active");
};

chatBox.onmouseleave = () => {
  chatBox.classList.remove("active");
};

let lastReceivedMsgId = 0; // Set the initial value to 0 or null if no messages have been received

function updateChat() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/get-chat.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  // Send the incoming_id and lastReceivedMsgId to the server
  const params = "incoming_id=" + incoming_id + "&last_received_msg_id=" + lastReceivedMsgId;
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = JSON.parse(xhr.responseText);
        let newMessages = data.output;
        lastReceivedMsgId = data.last_received_msg_id; // Update the last received msg_id

        chatBox.innerHTML += newMessages;

        // Scroll to the bottom only if new messages are received
        if (!chatBox.classList.contains("active")) {
          scrollToBottom();
        }
      }
    }
  };
  xhr.send(params);
}

// Call updateChat initially and every 500 milliseconds
updateChat();
setInterval(updateChat, 500);



function scrollToBottom() {
  chatBox.scrollTop = chatBox.scrollHeight;
}

//Image Attachment Code starts here
// Store the selected image file and caption in variables
let selectedImage = null;
let caption = '';

// Function to show the preview with image and caption
function showPreview(event) {
  const input = event.target;
  if (input.files && input.files[0]) {
    selectedFile = input.files[0];
    const reader = new FileReader();

    reader.onload = function (e) {
      const filePreview = document.getElementById("previewImage");
      const videoPreview = document.getElementById("previewVideo");
      const audioPreview = document.getElementById("previewAudio");

      if (selectedFile.type.startsWith("image/")) {
        filePreview.src = e.target.result;
        filePreview.style.display = "block";
        videoPreview.style.display = "none";
        audioPreview.style.display = "none";
      } else if (selectedFile.type.startsWith("video/")) {
        videoPreview.src = e.target.result;
        videoPreview.style.display = "block";
        filePreview.style.display = "none";
        audioPreview.style.display = "none";
      } else if (selectedFile.type.startsWith("audio/")) {
        audioPreview.src = e.target.result;
        audioPreview.style.display = "block";
        filePreview.style.display = "none";
        videoPreview.style.display = "none";
      }
    };

    reader.readAsDataURL(selectedFile);
    document.getElementById("preview-container").style.display = "flex";
    document.getElementById("preview-container").classList.add("preview-container-overlay");
  }
}


// Attach the showPreview function to the file input's onchange event
document.getElementById("attachButton").addEventListener("change", showPreview);

// Function to submit the image/audio/video with caption to the server
function submitFile() {
  // Retrieve the caption from the input field
  caption = document.getElementById("preview-input").value;

  // Ensure both file and caption are selected
  if (selectedFile) {
    // Create a new FormData object and append the file and caption
    const formData = new FormData();
    formData.append("attachment", selectedFile);
    formData.append("caption", caption);

    // Send the form data to the server using Fetch API or XMLHttpRequest
    fetch("php/upload.php", {
        method: "POST",
        body: formData,
      })
      .then((response) => {
        if (response.ok) {
          return response.text();
        } else {
          throw new Error("File upload failed.");
        }
      })
      .then((responseText) => {
        // Handle the response from upload.php
        cancelPreview();
      })
      .catch((error) => {
        // Handle any errors during the file upload process
        console.error(error);
      });
  } else {
    // Display an error message if file or caption is missing
    console.error("Please select a file and enter a caption.");
  }
}

// Function to cancel the preview and reset the selected file and caption
function cancelPreview() {
  selectedImage = null; // Reset the selected file
  caption = ''; // Reset the caption
  document.getElementById("attachButton").value = ""; // Clear the file input
  document.getElementById("preview-container").style.display = "none"; // Hide the preview
}