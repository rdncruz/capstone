const otp = document.querySelectorAll('.otp_field');

// Focus on the first input
otp[0].focus();

otp.forEach((field, index) => {
    field.addEventListener('input', (e) => {
        if (e.data >= 0 && e.data <= 9) {
            otp[index].value = e.data;
            if (index < otp.length - 1) {
                otp[index + 1].focus();
            }
        } else if (e.inputType === 'deleteContentBackward' && index > 0) {
            otp[index - 1].focus();
        }
    });
});


const form = document.querySelector('.wrapper form'),
continueBtn = form.querySelector(".button input"),
errortxt = form.querySelector('.error-text');

form.onsubmit = (e) => {
    e.preventDefault();
}

continueBtn.onclick = () => {

    const userType = document.body.dataset.userType || '';

    if (userType === 'users' || userType === 'seller') {
    // Start AJAX
    let xhr = new XMLHttpRequest();
    xhr.open('POST', './php/otp.php', true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                if (data === 'success') {
                    if (userType === 'users') {
                        location.href = './index.php';
                    } 
                    else if (userType === 'seller') {
                        location.href = './seller_login.php';
                    } 
                } 
                else {
                    errortxt.textContent = data;
                    errortxt.style.display = 'block';
                }
            }
        }
    };

    // Send data through AJAX to PHP
    let formData = new FormData(form);
    xhr.send(formData);
    } 
    else {
        alert("Invalid user type. Please check the file context.");
    }
}
