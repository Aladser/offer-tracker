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
            if (data = 1) {
                row.remove();
            } else {
                this.errorPrg.textContent = data;
            }
        })
    }

    /** установить статус
     * @param {*} row оффер
     * @param {*} inputStatus переключатель статуса 
     */
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
    
    update(row) {     

    }
}