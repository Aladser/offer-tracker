/** URL */
const offerURL = '/offer';
/** CSRF */
const csrfToken = document.querySelectorAll('meta')[2];
/** имя текущего пользователя*/
const hostUsername = document.querySelector('#hostUsername');
/** форма создания оффера */
let addProductForm = document.querySelector('#form-add-new-product');

/** фронт контроллер офферов */
const offerFrontCtl = new OfferFrontCtl(offerURL, hostUsername, addProductForm, csrfToken);