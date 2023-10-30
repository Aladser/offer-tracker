class CommissionCtl {
    constructor(url, commissionForm, msgPrg) {
        this.commissionInput = commissionForm.querySelector(
            "#input-change-commission"
        );
        this.commissionBtn = commissionForm.querySelector(
            "#btn-change-commission"
        );
        // url запроса на сервер
        this.url = url;
        // величина текущей комиссии
        this.commission = this.commissionInput.value;
        // обработчик ввода значения коммиссии
        this.commissionInput.oninput = this.input(this.commission);
        // событие отправки формы
        commissionForm.onsubmit = (e) => this.set(e);
        // поле результата добавления
        this.msgPrg = msgPrg;
    }

    // изменение комиссии
    input(commission) {
        let originalCommission = commission;
        let commissionBtn = this.commissionBtn;
        return function (e) {
            // введен минус
            if (e.data === "-") {
                e.target.value = originalCommission;
            }
            // сравнение с изначальным значением
            if (e.target.value == originalCommission) {
                commissionBtn.classList.add("hidden");
            } else {
                commissionBtn.classList.remove("hidden");
            }
        };
    }

    // отправка нового значения комиссии на сервер
    async set(e) {
        e.preventDefault();
        
        // действия после успешной записи комиссии в БД
        let process = (data) => {
            if (data.result == 1) {
                // скрытие кнопки установки коммиссии
                this.commissionBtn.classList.add("hidden");
                // установка новой комиссии
                this.commission = data.commission;
                this.commissionInput.oninput = this.input(data.commission);
            } else {
                this.msgPrg.textContent = data;
            }
        };
        // данные формы
        let formData = new FormData(e.target);

        ServerRequest.execute(
            this.url,
            process,
            "post",
            this.msgPrg,
            formData
        );
    }
}
