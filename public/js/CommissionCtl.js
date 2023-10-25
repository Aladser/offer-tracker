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
    async set(e) {
        e.preventDefault();
        ServerRequest.execute();
        
        let response = await fetch(this.url, {
            method: "post",
            body: new FormData(e.target),
        });
        switch (response.status) {
            case 200:
                let data = await response.json();
                if (data.result == 1) {
                    // скрытие кнопки установки коммиссии
                    this.commissionBtn.classList.add("d-none");
                    // установка новой комиссии
                    this.commission = data.commission;
                    this.commissionInput.oninput = this.input(data.commission);
                } else {
                    this.msgPrg.textContent = data;
                }
                break;
            case 419:
                window.open("/wrong-uri", "_self");
                break;
            default:
                this.msgPrg.textContent =
                    "Серверная ошибка. Подробности в консоли браузера";
                console.log(response);
        }
    }
}
