/** таблица офферов */
const offerTable = document.querySelector('#table-offers tbody');

/** CSRF */
const csrfToken = document.querySelector('meta[name="csrf-token"]');

/** фронт-контроллер офферов */
const offerService = new OfferService('/offer', offerTable, null, null, null, csrfToken);