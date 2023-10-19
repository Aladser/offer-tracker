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
                commissionBtn.classList.add("d-none");
            } else {
                commissionBtn.classList.remove("d-none");
            }
        };
    }

    // отправка нового значения комиссии на сервер
    set(e) {
        e.preventDefault();

        fetch(this.url, { method: "post", body: new FormData(e.target) })
            .then((response) => response.text())
            .then((data) => {
                try {
                    data = JSON.parse(data);
                    if (data.result == 1) {
                        // скрытие кнопки установки коммиссии
                        this.commissionBtn.classList.add("d-none");
                        // установка новой комиссии
                        this.commission = data.commission;
                        this.commissionInput.oninput = this.input(
                            data.commission
                        );
                    } else {
                        this.msgPrg.textContent = data;
                    }
                } catch (err) {
                    if (data.includes("<title>Page Expired</title>")) {
                        window.open("/wrong-uri", "_self");
                    } else {
                        this.msgPrg.textContent = err;
                        console.log(data);
                    }
                }
            });
    }
}
