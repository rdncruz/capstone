const form = document.querySelector('.formreg form'),
submitbtn = form.querySelector('.submit input'),
errortxt = form.querySelector('.error-text');


form.onsubmit = (e) => {
    e.preventDefault();
}

submitbtn.onclick = () => {
    //start ajax

    let xhr = new XMLHttpRequest(); // Create xml object
    xhr.open("POST", "./php/update_profile.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE) {
            if(xhr.status == 200) {
                let data = xhr.response;
                if(data == "success") {
                    location.href = "./user_verify.php"
                }
                else {
                    errortxt.textContent = data;
                    errortxt.style.display = "block";
                }
            }
        }
    };
    // send data through a jax to php
    let formData = new FormData(form); // creating new object from form data
    xhr.send(formData); /// sending data to php
}