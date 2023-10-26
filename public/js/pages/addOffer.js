/** поле результата добавления */
const msgPrg = document.querySelector("#form-add-error");
/** форма создания оффера */
const addOfferForm = document.querySelector("#form-add-new-product");
/** имя текущего пользователя*/
const username = document.querySelector("#navpanel-username").textContent;

/** фронт-контроллер офферов */
const offerTableController = new OfferTableClientController(
    "/offer",
    null,
    msgPrg,
    addOfferForm,
);
