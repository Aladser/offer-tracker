/** Клиентский табличный контроллер */
class TableClientController {
    /** Клиентский табличный контроллер
     * @param {*} URL URL бэк-контроллера
     * @param {*} table  таблица тем
     * @param {*} msgElement инфоэлемент
     * @param {*} form форма добавления элемента
     * @param {*} csrfToken csrf-токен
     */
    constructor(URL, table, msgElement, form) {
        this.URL = URL;
        this.table = table;
        this.msgElement = msgElement;
        this.form = form;
        this.csrfToken = document.querySelector('meta[name="csrf-token"]');

        // таблица
        if (this.table) {
            this.table
                .querySelectorAll(`.${this.table.id}__tr`)
                .forEach((row) => (row.onclick = (e) => this.clickRow(e)));
        }

        // форма добавления нового элемента
        if (this.form) {
            this.form.onsubmit = (event) => this.add(form, event);
        }
    }

    // добавить запись в БД
    add(form, event) {
        event.preventDefault();
        // действия после успешного добавления данных в БД
        let process = (data) => {
            if (data.result == 1) {
                this.processData(data.row, form);
            } else {
                this.msgElement.textContent = data.description;
            }
        };
        // данные формы
        let formData = new FormData(form);
        // заголовки
        let headers = {
            "X-CSRF-TOKEN": this.csrfToken.getAttribute("content"),
        };
        // запрос на сервер
        ServerRequest.execute(
            this.URL,
            process,
            "post",
            this.msgElement,
            formData,
            headers
        );
    }

    remove(row) {
        // заголовки
        let headers = {
            "X-CSRF-TOKEN": this.csrfToken.getAttribute("content"),
        };
        // действия после успешного удаления данных в БД
        let process = (data) => {
            if (data.result == 1) {
                // удаление данных из клиента
                row.remove();
                this.msgElement.textContent = "";
            } else {
                this.msgElement.textContent = data;
            }
        };
        // запрос на сервер
        ServerRequest.execute(
            `${this.URL}/${row.id}`,
            process,
            "delete",
            this.msgElement,
            null,
            headers
        );
    }

    /** клик строки */
    clickRow(e) {
        this.click(e.target.closest("tr"));
    };

    /** обработчик клика */
    click(row) {
        // клик на активную строку
        if (row.classList.contains(`${this.table.id}__tr--active`)) {
            row.classList.remove(`${this.table.id}__tr--active`);
            row.querySelector("button").remove();
        } else {
            // поиск активной строки
            let activeRow = this.table.querySelector(
                `.${this.table.id}__tr--active`
            );
            if (activeRow) {
                activeRow.querySelector("button").remove();
                activeRow.classList.remove(`${this.table.id}__tr--active`);
            }
            // выделение строки
            row.innerHTML += `<button id='${this.table.id}__btn-remove' class='h-full pe-2' title='Удалить'>🗑</button>`;
            row.lastChild.onclick = (e) => this.remove(e.target.closest("tr"));
            row.classList.add(`${this.table.id}__tr--active`);
        }
    }

    /** действия после добавления данных БД */
    processData(data, form) {
        alert("нет реализации метода processData класса TableFrontController");
    }
}
