/** Фронт-контроллер таблицы */
class OfferThemeFrontCtl {
    /** фронт-часть контроллера тем офферов
     * 
     * @param {*} URL URL бэк-контроллера
     * @param {*} offerThemeTable  таблица тем
     * @param {*} msgHTMLElement информационное поле
     * @param {*} addThemeForm форма добавления темы
     * @param {*} csrfToken csrf-токен
     */
    constructor(URL, offerThemeTable, msgHTMLElement, addThemeForm, csrfToken) {        
        this.URL = URL;
        this.offerThemeTable = offerThemeTable;
        this.msgHTMLElement = msgHTMLElement;
        this.addThemeForm = addThemeForm;
        this.csrfToken = csrfToken;

        this.offerThemeTable.querySelectorAll('.table-themes__tr').forEach(row => {
                row.onclick = e => this.clickRow(row, e.target.closest('tr'));
            }
        );

        this.addThemeForm.onsubmit = event => this.add(addThemeForm, event);
    }
    
    add(form, event) {
        event.preventDefault();
        let formData = new FormData(form);
        let headers = {'X-CSRF-TOKEN': this.csrfToken.getAttribute('content')};

        fetch(this.URL, {method:'post', headers: headers, body:formData}).then(response => response.text()).then(data => {
            try {
                data = JSON.parse(data);
                if (data.result == 1) {
                    form.reset();
                    this.offerThemeTable.querySelector('tbody').innerHTML += `<tr data-id="${data.row.id}" class='table-themes__tr position-relative'><td>${data.row.name}</td></tr>`;
                    this.msgHTMLElement.textContent = "";
                    this.offerThemeTable.querySelectorAll('.table-themes__tr').forEach(row => {
                            row.onclick = e => this.clickRow(e.target.closest('tr'));
                        }
                    );
                } else {
                    this.msgHTMLElement.textContent = data.result;
                }
            } catch(e) {
                if (data.includes('<title>Page Expired</title>')) {
                    window.open('/wrong-uri', '_self');
                } else {
                    this.msgHTMLElement.textContent = data;
                }
            }
        })
    }

    remove(button) {
        let row = button.closest('tr'); 
        let id = row.getAttribute('data-id');
        let headers = {'X-CSRF-TOKEN': this.csrfToken.getAttribute('content')};

        fetch(`${this.URL}/${id}`, {method:'delete', headers: headers}).then(response => response.text()).then(data => {
            try {
                data = JSON.parse(data);
                if (data.result == 1) {
                    row.remove();
                    this.msgHTMLElement.textContent = "";
                }
            } catch(e) {
                if (data.includes('<title>Page Expired</title>')) {
                    window.open('/wrong-uri', '_self');
                } else {
                    this.msgHTMLElement.textContent = data;
                }
            }
        })
    }

    clickRow(row) {
        if (row.classList.contains('table-themes__tr--active')) {
            row.classList.remove('table-themes__tr--active');
            row.querySelector('button').remove();
        } else {
            let activeRow = this.offerThemeTable.querySelector('.table-themes__tr--active');
            if (activeRow) {
                activeRow.classList.remove('table-themes__tr--active');
                this.offerThemeTable.querySelector('button').remove();
            }

            row.innerHTML += "<button id='table-themes__btn-remove' title='Удалить'>🗑</button>";
            row.lastChild.onclick = e => offerThemeFrontCtl.remove(e.target);
            row.classList.add('table-themes__tr--active');
        }
    }
}