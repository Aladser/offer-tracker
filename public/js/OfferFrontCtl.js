/** Коллекция машин*/
class OfferFrontCtl {
    constructor(URL, userName, form, errorPrg, csrfToken) {
        this.form = form;
        this.URL = URL;
        this.userName = userName;
        this.form.onsubmit = e => this.add(e);
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
                    this.errorPrg.textContent = "OK";
                }
            } catch(err) {
                console.log(data);
                this.errorPrg.textContent = 'Ошибка БД';
            }
        })
    }

    update(row) {     

    }

    remove(row) {

    }
}