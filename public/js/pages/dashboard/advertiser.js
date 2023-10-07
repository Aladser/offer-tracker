/** таблица офферов */
const offerTable = document.querySelector('#table-offers');

/** CSRF */
const csrfToken = document.querySelector('meta[name="csrf-token"]');

/** поле результата добавления */
const msgPrg = document.querySelector('#prg-error');

/** фронт-контроллер офферов */
const offerService = new OfferTableFrontController('/offer', offerTable, msgPrg, null, csrfToken, null);

/** вебсокет */
const websocket = new FrontWebsocket('ws://localhost:8888');