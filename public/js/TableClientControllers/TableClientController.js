/** Клиентский табличный контроллер */
class TableClientController {
    /**
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
        if (this.table !== null) {
            this.table.querySelectorAll(`.${this.table.id}__tr`).forEach(
                (row) =>
                    (row.onclick = (e) => {
                        // переключатель меняет статус стрки
                        if (e.target.tagName === "INPUT") {
                            this.setStatus(e.target.closest("tr"), e.target);
                        } else {
                            this.click(e.target.closest("tr"));
                        }
                    })
            );
        }

        // форма добавления нового элемента
        if (this.form !== null) {
            this.form.onsubmit = (event) => this.add(form, event);
        }
    }

    add(form, event) {
        event.preventDefault();
        let formData = new FormData(form);
        let headers = {
            "X-CSRF-TOKEN": this.csrfToken.getAttribute("content"),
        };

        fetch(this.URL, { method: "post", headers: headers, body: formData })
            .then((response) => response.text())
            .then((data) => {
                try {
                    data = JSON.parse(data);
                    if (data.result == 1) {
                        this.processData(form, data);
                    } else {
                        this.msgElement.textContent = data.description;
                    }
                } catch (e) {
                    if (data.includes("<title>Page Expired</title>")) {
                        window.open("/wrong-uri", "_self");
                    } else {
                        this.msgElement.textContent = data;
                    }
                }
            });
    }

    remove(row) {
        let headers = {
            "X-CSRF-TOKEN": this.csrfToken.getAttribute("content"),
        };

        fetch(`${this.URL}/${row.id}`, { method: "delete", headers: headers })
            .then((response) => response.text())
            .then((data) => {
                try {
                    data = JSON.parse(data);
                    if (data.result == 1) {
                        row.remove();
                        this.msgElement.textContent = "";
                    } else {
                        this.msgElement.textContent = data;
                    }
                } catch (err) {
                    if (data.includes("<title>Page Expired</title>")) {
                        window.open("/wrong-uri", "_self");
                    } else {
                        this.msgElement.textContent = err;
                        console.log(data);
                    }
                }
            });
    }

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
            row.innerHTML += `<button id='${this.table.id}__btn-remove' title='Удалить'>🗑</button>`;
            row.lastChild.onclick = (e) => this.remove(e.target.closest("tr"));
            row.classList.add(`${this.table.id}__tr--active`);
        }
    }

    /** действия после добавления данных БД */
    processData(data) {
        alert("нет реализации метода processData класса TableFrontController");
    }
}
