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
            username,
            table,
            msgPrg
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
        this.websocket.sendData({
            type:'ADDING_NEW_OFFER',
            name: this.form.name.value,
            price: this.form.price.value,
            url: this.form.url.value,
            theme: this.form.theme.value,
            advertiser: this.username
        });
    }
}
