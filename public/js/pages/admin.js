// url бэк-части установки комиссии
const url = 'api/commission';

// форма комиссиии
const commissionForm = document.querySelector('#form-change-commission');

/** поле результата добавления */
const msgPrg = document.querySelector('#prg-error');

/** контроллер элемента комиссии */
const commissionCtl = new CommissionCtl(url, commissionForm, msgPrg);

/** вебсокет */
const websocket = new FrontWebsocket('ws://localhost:8888');