/** Контроллер офферов */
class OfferTableClientController extends TableClientController {
    /**
     *
     * @param {*} URL адрес запросов к серверу
     * @param {*} table таблица 'элементов
     * @param {*} msgPrg информационное поле
     * @param {*} form форма добавления нового элемента
     * @param {*} csrfToken csrf-токен
     * @param {*} username имя пользователя
     */
    constructor(URL, table, msgPrg, form, username) {
        super(URL, table, msgPrg, form);
        this.username = username;

        if (this.form !== null) {
            this.form.onsubmit = (event) => this.add(event);
        }

        /** вебсокет */
        this.websocket = new AdvertiserClientWebsocket(
            "ws://localhost:8888",
            this.username,
            this.table
        );

        if (this.table !== null) {
            this.table.querySelectorAll(".offers__item").forEach((offer) => {
                let btn = offer.querySelector(".offers__btn-remove");
                btn.onclick = () => this.remove(btn.closest(".offers__item"));
            });
        }
    }

    /** добавить оффер в БД
     * @param {*} form форма нового оффера
     * @param {*} msgHTMLElement HTML-элемент поля информации
     * @param {*} username HTML-элемент имени пользователя
     * @param {*} event
     */
    add(event) {
        event.preventDefault();
        let formData = new FormData(this.form);
        formData.append("user", this.username);

        fetch(this.URL, { method: "post", body: formData })
            .then((response) => response.text())
            .then((data) => {
                try {
                    let offer = JSON.parse(data);

                    if (offer.result == 1) {
                        event.target.reset();
                        this.msgElement.textContent = `${offer.offerName} добавлен`;
                    } else {
                        this.msgElement.textContent = offer.error;
                    }
                } catch (err) {
                    if (data.includes("<title>Page Expired</title>")) {
                        window.open("/wrong-uri", "_self");
                    } else {
                        this.msgElement.textContent = err;
                    }
                }
            });
    }
}
