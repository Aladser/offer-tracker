const productCtl = new ProductCtl();
const addProductForm = document.querySelector('#form-add-new-product');

window.addEventListener('DOMContentLoaded', () => {
    addProductForm.onsubmit = productCtl.add;
});