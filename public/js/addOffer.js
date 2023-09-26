/** URL */
const offerURL = '/offer';
/** CSRF */
const csrfToken = document.querySelector('meta[name="csrf-token"]');
/** фронт-контроллер офферов */
const offerFrontCtl = new OfferFrontCtl(offerURL, csrfToken);

/** форма создания оффера */
const addOfferForm = document.querySelector('#form-add-new-product');
/** поле результата добавления */
const msgPrg = document.querySelector('#form-add-error');
/** имя текущего пользователя*/
const hostUsernameHTMLElement = document.querySelector('#navpanel-username');

addOfferForm.onsubmit = event => offerFrontCtl.add(addOfferForm, msgPrg, hostUsernameHTMLElement, event);

/** кнопка назад */
document.querySelector('#form-add-new__btn-back').onclick = () => window.open('/dashboard', '_self');