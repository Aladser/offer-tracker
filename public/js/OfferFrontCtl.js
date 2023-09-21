/** Коллекция машин*/
class OfferFrontCtl {
    constructor(URL, userName, form, offerTable, errorPrg, csrfToken) {
        this.form = form;
        this.URL = URL;
        this.userName = userName;
        this.form.onsubmit = e => this.add(e);
        this.offerTable = offerTable;
        this.errorPrg = errorPrg;
        this.csrfToken = csrfToken;
    }
    
    add(e) {
        e.preventDefault();
        let formData = new FormData(this.form);
        formData.append('user', this.userName.textContent);
        let headers = {'X-CSRF-TOKEN': this.csrfToken.getAttribute('content')};
        
        fetch(this.URL, {method:'post', headers: headers, body:formData}).then(response => response.text()).then(data => {
            try {
                let offer = JSON.parse(data);
                if (offer.result === 0) {
                    this.errorPrg.textContent = offer.error;
                } else {
                    this.showRow(offer.row);
                    this.errorPrg.textContent = '';
                }
            } catch(err) {
                console.log(data);
                this.errorPrg.textContent = 'Ошибка БД';
            }
        })
    }

    showRow(data) {
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

    remove(row) {

    }

    update(row) {     

    }
}