// форма комиссиии
const commissionForm = document.querySelector("#form-change-commission");
/** поле результата добавления */
const msgPrg = document.querySelector("#prg-error");
/** контроллер элемента комиссии */
const commissionCtl = new CommissionCtl("/commission", commissionForm, msgPrg);

/** вебсокет */
const websocket = new AdminClientWebsocket();
