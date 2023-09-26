/** Фронт-контроллер офферов */
class OfferFrontCtl {
    /**
     * 
     * @param {*} URL URL сервера
     * @param {*} offerTable таблица офферов
     * @param {*} csrfToken csrf-токен
     */
    constructor(URL, csrfToken) {        
        this.URL = URL;
        this.csrfToken = csrfToken;
    }
    
    /**
     * добавить оффер в БД
     * @param {*} form форма нового оффера
     * @param {*} msgHTMLElement HTML-элемент поля информации 
     * @param {*} username HTML-элемент имени пользователя
     * @param {*} event
     */
    add(form, msgHTMLElement, username, event) {
        event.preventDefault();
        let formData = new FormData(form);
        formData.append('user', username.textContent);
        
        fetch(this.URL, {method:'post', body:formData}).then(response => response.text()).then(data => {
            try {
                let offer = JSON.parse(data);
                if (offer.result === 1) {
                    event.target.reset();
                    msgHTMLElement.textContent = `${offer.offerName} добавлен`;
                } else {
                    msgHTMLElement.textContent = offer.error;
                }
            } catch(err) {
                console.log(data);
                msgHTMLElement.textContent = 'Ошибка БД. Подробности смотри в консоли';
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
                this.errorPrg.textContent = data;
            }
        })
    }

    /** установить статус */
    setOfferStatus(row, inputStatus) {
        let data = new URLSearchParams();
        data.set('id', row.getAttribute('data-id'));
        data.set('status', inputStatus.checked);
        let headers = {'X-CSRF-TOKEN': this.csrfToken.getAttribute('content')};

        fetch(`${this.URL}/status`, {method:'post', headers: headers, body:data}).then(response => response.text()).then(rslt => {
            if (rslt != 1) {
                this.errorPrg.textContent = 'ошибка ДБ';
                console.log(rslt);
            }
        })
    }

    /** клик строки таблицы */
    static clickRow(offerTable, row) {
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
            row.lastChild.onclick = e => offerFrontCtl.remove(e.target);
            // флаг новой выделенной строки
            row.classList.add('table-offers__tr--active');
        }
    }
}