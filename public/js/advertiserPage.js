/** URL */
const offerURL = '/offer';
/** имя текущего пользователя*/
const hostUsername = document.querySelector('#hostUsername');
/** форма создания оффера */
const addOfferForm = document.querySelector('#form-add-new-product');
/** поле ошибки формы добавления */
const errorPrg = document.querySelector('#form-add-error');
/** CSRF */
const csrfToken = document.querySelector('meta[name="csrf-token"]');
/** таблица офферов */
const offerTable = document.querySelector('#table-offers tbody');

/** фронт-контроллер офферов */
const offerFrontCtl = new OfferFrontCtl(offerURL, hostUsername, addOfferForm, offerTable, errorPrg, csrfToken);