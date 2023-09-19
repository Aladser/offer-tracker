/** Коллекция машин*/
class ProductCtl {
    constructor() {

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