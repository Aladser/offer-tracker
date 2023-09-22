/** Коллекция машин*/
class OfferFrontCtl {
    constructor(URL, userName, form, offerTable, errorPrg, csrfToken) {
        this.form = form;
        this.form.onsubmit = e => this.add(e);
        
        this.URL = URL;
        this.userName = userName;
        this.offerTable = offerTable;
        this.errorPrg = errorPrg;
        this.csrfToken = csrfToken;

        // клик на строке
        offerTable.querySelectorAll('.table-offers__tr').forEach(row => row.onclick = e => {
            if (e.target.tagName === 'INPUT') {
                this.setOfferStatus(e.target.closest('tr'), e.target);
            } else {
                this.click(e.target.closest('tr'));
            }
        });
    }
    
    click(row) {
        if (row.classList.contains('table-offers__tr--active')) {
            row.classList.remove('table-offers__tr--active');
            row.querySelector('button').remove();
        } else {
            let activeRow = this.offerTable.querySelector('.table-offers__tr--active');
            if (activeRow) {
                activeRow.classList.remove('table-offers__tr--active');
                this.offerTable.querySelector('button').remove();
            }

            // кнопка удаления
            row.innerHTML += "<button id='table-offers__btn-remove' title='Удалить'>🗑</button>";
            row.lastChild.onclick = e => this.remove(e.target);

            row.classList.add('table-offers__tr--active');
        }
    }

    add(event) {
        event.preventDefault();
        let formData = new FormData(this.form);
        formData.append('user', this.userName.textContent);
        
        fetch(this.URL, {method:'post', body:formData}).then(response => response.text()).then(data => {
            try {
                let offer = JSON.parse(data);
                if (offer.result === 0) {
                    this.errorPrg.textContent = offer.error;
                } else {
                    this.addDOMRow(offer.row);
                    event.target.reset();
                    this.errorPrg.textContent = '';
                }
            } catch(err) {
                console.log(data);
                this.errorPrg.textContent = 'Ошибка БД';
            }
        })
    }

    addDOMRow(data) {
       this.offerTable.innerHTML += `<tr data-id="${data.id}">`
        +`<td class="fw-bolder">${data.name}</td>`
        +`<td>${data.price}</td>`
        +'<td class="p-0">'
        +'<div class="form-switch p-0 h-100">'
        +'<input type="checkbox" name="status" class="form-check-input mx-auto">'
        +'</div>'
        +'</td>'
        +'<td>0</td>'
        +'<tr>';
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