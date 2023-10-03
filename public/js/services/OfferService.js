/** Фронт-контроллер офферов */
class OfferService {
    /** Фронт-контроллер офферов
     * @param {*} URL url бэк-части
     * @param {*} offerTable таблица офферов
     * @param {*} addOfferForm форма добавления нового оффера
     * @param {*} msgPrg поле ошибок
     * @param {*} username имя пользователя
     * @param {*} csrfToken csrf-токен
     */
    constructor(URL, offerTable, addOfferForm, msgPrg, username, csrfToken) {        
        this.URL = URL;
        this.offerTable = offerTable;
        this.addOfferForm = addOfferForm;
        this.msgPrg = msgPrg;
        this.username = username;
        this.csrfToken = csrfToken;

        // таблица офферов
        if (this.offerTable !== null) {
            this.offerTable.querySelectorAll('.table-offers__tr').forEach(row => row.onclick = e => {
                    if (e.target.tagName === 'INPUT') {
                        this.setOfferStatus(e.target.closest('tr'), e.target);
                    } else {
                        this.clickRow(offerTable, e.target.closest('tr'));
                    }
                }
            );
        }

        // форма добавления нового оффера
        if (this.addOfferForm != null) {
            this.addOfferForm.onsubmit = event =>this.add(event);
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
        let formData = new FormData(this.addOfferForm);
        formData.append('user', this.username);
        
        fetch(this.URL, {method:'post', body:formData}).then(response => response.text()).then(data => {
            try {
                let offer = JSON.parse(data);
                if (offer.result === 1) {
                    event.target.reset();
                    this.msgPrg.textContent = `${offer.offerName} добавлен`;
                } else {
                    this.msgPrg.textContent = offer.error;
                }
            } catch(err) {
                if (data.includes('<title>Page Expired</title>')) {
                    window.open('/wrong-uri', '_self');
                } else {
                    this.msgPrg.textContent = data;
                }
            }
        })
    }

    remove(button) {
        let row = button.closest('tr'); 
        let id = row.getAttribute('data-id');
        let headers = {'X-CSRF-TOKEN': this.csrfToken.getAttribute('content')};
        fetch(`${this.URL}/${id}`, {method:'delete', headers: headers}).then(response => response.text()).then(data => {
            try{
                let rslt = JSON.parse(data);
                if (rslt.response === 1) {
                    row.remove();
                } else {
                    this.errorPrg.textContent = data;
                }
            } catch(e) {
                if (data.includes('<title>Page Expired</title>')) {
                    window.open('/wrong-uri', '_self');
                } else {
                    this.msgPrg.textContent = data;
                }
            }
        })
    }

    /** клик строки таблицы */
    clickRow(offerTable, row) {
        if (row.classList.contains('table-offers__tr--active')) {
            row.classList.remove('table-offers__tr--active');
            row.querySelector('button').remove();
        } else {
            let activeRow = offerTable.querySelector('.table-offers__tr--active');
            if (activeRow) {
                activeRow.classList.remove('table-offers__tr--active');
                offerTable.querySelector('button').remove();
            }

            // кнопка удаления
            row.innerHTML += "<button id='table-offers__btn-remove' title='Удалить'>🗑</button>";
            // удаление строки при нажатии кнопки удаления
            row.lastChild.onclick = e => this.remove(e.target);
            // флаг новой выделенной строки
            row.classList.add('table-offers__tr--active');
        }
    }

    /** установить статус */
    setOfferStatus(row, inputStatus) {
        let data = new URLSearchParams();
        data.set('id', row.getAttribute('data-id'));
        data.set('status', inputStatus.checked);
        let headers = {'X-CSRF-TOKEN': this.csrfToken.getAttribute('content')};

        let statusSwitch = row.querySelector("input[name='status']");
        fetch(`${this.URL}/status`, {method:'post', headers: headers, body:data}).then(response => response.text()).then(rslt => {
            if (rslt == 1) {
                statusSwitch.title = inputStatus.checked ? 'выключить' : 'включить';
            } else {
                this.errorPrg.textContent = "серверная ошибка изменения статуса";
                console.log(rslt);
            }
        })
    }
}