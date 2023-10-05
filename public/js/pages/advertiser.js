/** таблица офферов */
const offerTable = document.querySelector('#table-offers');

/** CSRF */
const csrfToken = document.querySelector('meta[name="csrf-token"]');

/** поле результата добавления */
const msgPrg = document.querySelector('#prg-error');

/** фронт-контроллер офферов */
const offerService = new OfferService('/offer', offerTable, msgPrg, null, csrfToken, null);