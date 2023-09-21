/** URL */
const offerURL = '/offer';
/** имя текущего пользователя*/
const hostUsername = document.querySelector('#hostUsername');
/** форма создания оффера */
const addOfferForm = document.querySelector('#form-add-new-product');
/** поле ошибки формы добавления */
const errorPrg = document.querySelector('#form-add-error');
/** CSRF */
const csrfToken = document.querySelectorAll('meta')[2];

/** фронт-контроллер офферов */
const offerFrontCtl = new OfferFrontCtl(offerURL, hostUsername, addOfferForm, errorPrg, csrfToken);