const form = document.querySelector('.form form'),
submitbtn = form.querySelector('.submit .button'),
errortxt = form.querySelector('.error-text');


form.onsubmit = (e) => {
    e.preventDefault();
}

submitbtn.onclick = () => {
    //start ajax

    let xhr = new XMLHttpRequest(); // Create xml object
    xhr.open("POST", "./php/logins.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE) {
            if(xhr.status == 200) {
                let data = xhr.response;
                if(data == "success") {
                    location.href = "./index.php"
                }
                if(data == "success seller") {
                    location.href = "./seller.php"
                }
                else {
                    errortxt.textContent = data;
                    errortxt.style.display = "block";
                }
            }
        }
    }
    // send data through a jax to php
    let formData = new FormData(form); // creating new object from form data
    xhr.send(formData); /// sending data to php
}