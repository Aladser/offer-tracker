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
    constructor(URL, table, msgPrg, form) {
        super(URL, table, msgPrg, form);
        this.username = document.querySelector('meta[name="username"]').content;

        if (this.form !== null) {
            this.form.onsubmit = (event) => this.add(event);
        }

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
    async add(event) {
        event.preventDefault();
        // данные формы
        let formData = new FormData(this.form);
        formData.append("user", this.username);
        // csrf отправляется в данных формы
        // действия после успешного добавления оффера в БД
        let process = (offer) => {
            if (offer.result == 1) {
                event.target.reset();
                this.msgElement.textContent = `${offer.offerName} добавлен`;
            } else {
                this.msgElement.textContent = offer.error;
            }
        };
        // запрос на сервер
        ServerRequest.execute(
            this.URL,
            process,
            "post",
            this.msgElement,
            formData
        );
    }
}
