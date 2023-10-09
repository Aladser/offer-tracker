class CommissionCtl
{
    constructor(url, commissionForm, msgPrg) {
        this.url = url;
        // форма комиссиии
        this.commissionForm = commissionForm;
        this.commissionInput = commissionForm.querySelector('#input-change-commission');
        this.commissionBtn = commissionForm.querySelector('#btn-change-commission');
        this.commissionInput.oninput = this.input();
        this.commissionForm.onsubmit = e => this.set(e);
        /** поле результата добавления */
        this.msgPrg = msgPrg;
    }

    // изменение комиссии
    input() {
        let originalCommission = this.commissionInput.value;
        let commissionBtn = this.commissionBtn;
        return function(e) {
            // введен минус
            if (e.data === '-') {
                e.target.value = originalCommission;
            }
            // сравнение с изначальным значением
            if (e.target.value == originalCommission) {
                commissionBtn.classList.add('d-none');
            } else {
                commissionBtn.classList.remove('d-none');
            }
        };
    }

    // отправка нового значения комиссии на сервер
    set(e) {
        e.preventDefault();
        this.commissionBtn.classList.add('d-none');

        let formData = new FormData(this.commissionForm);
        fetch(this.url, {method:'post', body:formData}).then(response => response.text()).then(data => {
            try {
                let result = JSON.parse(data).result;
                if (result != 1) {
                    this.msgPrg.textContent = data;    
                }
            } catch(err) {
                if (data.includes("<title>Page Expired</title>")) {
                    window.open("/wrong-uri", "_self")
                } else {
                    this.msgPrg.textContent = err;
                    console.log(data);
                }
            }
        });
    }
}