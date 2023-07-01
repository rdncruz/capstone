const form = document.querySelector('.form form');
const submitBtn = document.getElementById('submitBtn');
const errorTxt = document.querySelector('.error-text');

form.onsubmit = (e) => {
    e.preventDefault();
};

submitBtn.onclick = () => {
    const xhr = new XMLHttpRequest();
    const url = './php/add.php';

    xhr.open('POST', url, true);

    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const data = xhr.response;
                if (data === 'success') {
                    location.href = './product.php';
                } 
                else {
                    errorTxt.textContent = data;
                    errorTxt.style.display = 'block';
                }
            }
        }
    };

    const formData = new FormData(form);
    xhr.send(formData);
};
