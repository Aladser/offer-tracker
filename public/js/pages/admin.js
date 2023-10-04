/** комиссия и ее изменение*/
const commissionForm = document.querySelector('#form-change-commission');
const commissionInput = document.querySelector('#input-change-commission');
const commissionBtn = document.querySelector('#btn-change-commission');

/** поле результата добавления */
const msgPrg = document.querySelector('#prg-error');

// изменение комиссии
commissionInput.oninput = setInputCommission();
function setInputCommission() {
    let originalCommission = commissionInput.value;
    return function(e) {
        // введен минус
        if (e.data === '-') {
            commissionInput.value = originalCommission;
        }
        // сравнение с изначальным значением
        if (commissionInput.value == originalCommission) {
            commissionBtn.classList.add('d-none');
        } else {
            commissionBtn.classList.remove('d-none');
        }
    };
}

// отправка новой комиссии на сервер
commissionForm.onsubmit = function(e) {
    e.preventDefault();
    commissionBtn.classList.add('d-none');

    let formData = new FormData(commissionForm);
    fetch('api/commission', {method:'post', body:formData}).then(response => response.text()).then(data => {
        try {
            let result = JSON.parse(data).result;
            if (result != 1) {
                msgPrg.textContent = data;    
            }
        } catch(e) {
            msgPrg.textContent = data;
        }
    });
};