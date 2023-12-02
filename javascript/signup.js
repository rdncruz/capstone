const form = document.querySelector(".signup form"),
  continueBtn = form.querySelector(".button input"),
  errorText = form.querySelector(".error-text");

form.onsubmit = (e) => {
  e.preventDefault();
};

continueBtn.onclick = () => {
  const userType = document.body.dataset.userType || '';
  if (userType === 'users' || userType === 'seller' || userType === 'admin') {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./php/signup.php", true);
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          let data = xhr.response;
          if (data === "success") {
            if (userType === 'users') {
              swal("You've been register!", "Please Wait for the OTP Verification", "success")
              .then(() => {
                location.href = './index.php';
              });
            } else if (userType === 'seller') {
              swal("You've been register!", "Please Wait for the admin to send the OTP Verification", "success")
              .then(() => {
                location.href = './seller_login.php';
              });
            } else if (userType === 'admin') {
              location.href = './admin_portal.php';
            }
          } else {
            errorText.style.display = "block";
            errorText.textContent = data;
          }
        }
      }
    };
    let formData = new FormData(form);
    xhr.send(formData);
  } else {
    alert("Invalid user type. Please check the file context.");
  }
};
