/** Коллекция машин*/
class OfferFrontCtl {
    constructor(URL, form) {
        this.form = form;
        this.URL = URL;
        this.form.onsubmit = e => this.add(e);
    }
    
    add(e) {
        e.preventDefault();
        let formData = new FormData(this.form);
        
        fetch(this.URL, {method:'post', body:formData}).then(response => response.text()).then(data => {
            try {
                let offer = JSON.parse(data);
                console.clear();
                alert(offer);
            } catch(err) {
                console.clear();
                console.log(data);
            }
        })
    }

    update(row) {     

    }

    remove(row) {

    }
}