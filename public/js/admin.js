/** комиссия и ее изменение*/
const commissionForm = document.querySelector('#form-change-commission');
const commissionInput = document.querySelector('#input-change-commission');
const commissionBtn = document.querySelector('#btn-change-commission');

// изменение комиссии
commissionInput.oninput = setInputCommission();
function setInputCommission() {
    let commission = commissionInput.value;
    return function() {
        if (commissionInput.value == commission) {
            commissionBtn.classList.add('d-none');
        } else {
            commissionBtn.classList.remove('d-none');
        }
    }
}

commissionForm.onsubmit = function(e) {
    e.preventDefault();
    commissionValue = e.target.commission.value;
    commissionBtn.classList.add('d-none');
}