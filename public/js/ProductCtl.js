/** Коллекция машин*/
class ProductCtl {
    constructor(form) {
        this.form = form;
        this.form.onsubmit = this.add;
    }
    
    add(form) {
        form.preventDefault();
        let formData = new FormData(form.target);
        console.log(form.target.name.value);
        console.log(form.target.price.value);
        console.log(form.target.url.value);
        console.log(form.target.theme.value);
        
    }

    update(row) {     

    }

    remove(row) {

    }
}