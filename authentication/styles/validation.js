function validateForm() {
    var emailInput = document.getElementById("emailInput");
    var usernameInput = document.getElementById("usernameInput");
    var passwordInput = document.getElementById("passwordInput");

    var errors = [];

    // Validate email
    if (!validateEmail(emailInput.value)) {
        errors.push("Invalid email format");
    }

    // Validate username
    if (!validateUsername(usernameInput.value)) {
        errors.push("Invalid username format");
    }

    // Validate password length
    if (passwordInput.value.length < 6) {
        errors.push("Password must be atleast 6 characters long");
    }

    // Display errors if any
    if (errors.length > 0) {
        displayClientErrors(errors);
        console.log("errors")
        return false; // Prevent form submission
    }
    return true; // Proceed with form submission
}

function displayClientErrors(errors) {
    var errorContainer = document.getElementById("clientErrors");

    // Clear previous errors
    errorContainer.innerHTML = "";

    // Create and append error list
    var errorList = document.createElement("ul");
    errors.forEach(function (error) {
        var listItem = document.createElement("li");
        listItem.textContent = error;
        errorList.appendChild(listItem);
    });

    errorContainer.appendChild(errorList);
}

// Function to validate email format
function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

// Function to validate username format
function validateUsername(username) {
    return /^[a-zA-Z0-9_]+$/.test(username);
}