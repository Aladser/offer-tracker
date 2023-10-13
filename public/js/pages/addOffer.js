/** URL */
const offerURL = "/offer";
/** поле результата добавления */
const msgPrg = document.querySelector("#form-add-error");
/** форма создания оффера */
const addOfferForm = document.querySelector("#form-add-new-product");
/** CSRF */
const csrfToken = document.querySelector('meta[name="csrf-token"]');
/** имя текущего пользователя*/
const username = document.querySelector("#navpanel-username").textContent;
/** фронт-контроллер офферов */
const offerTableController = new OfferTableClientController(
    offerURL,
    null,
    msgPrg,
    addOfferForm,
    csrfToken,
    username
);
