/** URL */
const offerURL = '/offer';

/** форма создания оффера */
const addOfferForm = document.querySelector('#form-add-new-product');

/** CSRF */
const csrfToken = document.querySelector('meta[name="csrf-token"]');

/** поле результата добавления */
const msgPrg = document.querySelector('#form-add-error');

/** имя текущего пользователя*/
const username = document.querySelector('#navpanel-username').textContent;

/** фронт-контроллер офферов */
const offerService = new OfferService(offerURL, null, addOfferForm, msgPrg, username, csrfToken);