const form = document.querySelector(".login form"),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-text");

form.onsubmit = (e)=>{
    e.preventDefault();
}

continueBtn.onclick = () => {
  const userType = document.body.dataset.userType || '';
  console.log("User type:", userType); // Debugging statement

  const validUserTypes = ['user', 'seller', 'admin'];

  if (validUserTypes.includes(userType)) {
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "php/login.php", true);

      xhr.onload = () => {
          if (xhr.readyState === XMLHttpRequest.DONE) {
              if (xhr.status === 200) {
                  let data = xhr.response;
                  console.log("Response from server:", data); // Debugging statement

                  if (data.trim() === "success") {
                      redirectBasedOnUserType(userType);
                  } else {
                      handleLoginError(data);
                  }
              }
          }
      };

      xhr.onerror = () => {
          console.error("Error occurred during the request.");
          handleLoginError("An error occurred during the request.");
      };

      let formData = new FormData(form);
      xhr.send(formData);
  } else {
      alert("Invalid user type. Please check the file context.");
  }
};

function redirectBasedOnUserType(userType) {
  console.log(`Redirecting to ${userType}_verify.php`);
  location.href = `./${userType}_verify.php`;
}

function handleLoginError(errorMessage) {
  console.log("Displaying error:", errorMessage);
  errorText.style.display = "block";
  errorText.textContent = errorMessage;
}
