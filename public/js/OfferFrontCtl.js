/** Коллекция машин*/
class OfferFrontCtl {
    constructor(URL, userName, form, csrfToken) {
        this.form = form;
        this.URL = URL;
        this.userName = userName;
        this.form.onsubmit = e => this.add(e);
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
                console.clear();
                console.log(offer);
            } catch(err) {
                alert('ошибка добавления оффера');
                console.log(data);
            }
        })
    }

    update(row) {     

    }

    remove(row) {

    }
}