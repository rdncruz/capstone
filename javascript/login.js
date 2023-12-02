const form = document.querySelector(".login form"),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-text");

form.onsubmit = (e)=>{
    e.preventDefault();
}

continueBtn.onclick = ()=>{
  const userType = document.body.dataset.userType || '';
  if (userType === 'user' || userType === 'seller' || userType === 'admin') {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/login.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
            let data = xhr.response;
            if(data === "success"){
              if (userType === 'user') {
                location.href = './home.php';
              } 
              else if (userType === 'seller') {
                  location.href = './seller_dashboard.php';
              } 
              else if (userType === 'admin') {
                location.href = './admin_portal.php';
            } 
            }else{
              errorText.style.display = "block";
              errorText.textContent = data;
            }
        }
    }
  }
  let formData = new FormData(form);
  xhr.send(formData);
  } 
  else {
    alert("Invalid user type. Please check the file context.");
  }
}