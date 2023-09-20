const offerURL = '/offer';
/** форма создания оффера */
let addProductForm = document.querySelector('#form-add-new-product');
/** фрон контроллер офферов */
const offerFrontCtl = new OfferFrontCtl(offerURL, addProductForm);