const form = document.querySelector('.logform form'),
submitbtn = form.querySelector('.submit button'),
errortxt = form.querySelector('.error-text');


form.onsubmit = (e) => {
    e.preventDefault();
}

submitbtn.onclick = () => {
    //start ajax

    let xhr = new XMLHttpRequest(); // Create xml object
    xhr.open("POST", "./php/user_login.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE) {
            if(xhr.status == 200) {
                let data = xhr.response;
                if(data == "success") {
                    location.href = "./index.php"
                    
                }
                else {
                    alert("Wrong Credentials");
                    
                }
            }
        }
    }
    // send data through a jax to php
    let formData = new FormData(form); // creating new object from form data
    xhr.send(formData); /// sending data to php
}