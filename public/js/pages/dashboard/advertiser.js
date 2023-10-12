/** таблица офферов */
const offerTable = document.querySelector('#table-offers');
/** CSRF */
const csrfToken = document.querySelector('meta[name="csrf-token"]');
/** поле результата добавления */
const msgPrg = document.querySelector('#prg-error');
/** пользователь*/
const user = document.querySelector("#element-username").textContent;
/** фронт-контроллер офферов */
const offerTableController = new OfferTableClientController('/offer', offerTable, msgPrg, null, csrfToken, user);