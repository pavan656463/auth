
// Function to set the focus state, typed value, and value to localStorage
function setFocusState() {
    var taskTitleInput = document.getElementById("title");
    localStorage.setItem("titleValue", taskTitleInput.value);
    localStorage.setItem("isTitleFocused", document.activeElement === taskTitleInput);
}

// Function to restore the focus state and typed value from localStorage
function restoreFocusState() {
    var taskTitleInput = document.getElementById("title");
    var titleValue = localStorage.getItem("titleValue");
    taskTitleInput.value = titleValue || ""; // Set the value from localStorage, default to an empty string
    var isFocused = localStorage.getItem("isTitleFocused") === "true";
    if (isFocused) {
        taskTitleInput.focus();
    }
}

// Call restoreFocusState when the page loads
window.onload = function () {
    restoreFocusState();
};

// Save the focus state, typed value, and value to localStorage before the page is reloaded
window.onbeforeunload = function () {
    setFocusState();
};

// Reload the page every 5 seconds
setInterval(function () {
    location.reload();
}, 5000);
<<<<<<< HEAD

=======
>>>>>>> lib
