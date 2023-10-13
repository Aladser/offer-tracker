// url бэк-части установки комиссии
const url = "/commission";
// форма комиссиии
const commissionForm = document.querySelector("#form-change-commission");
/** поле результата добавления */
const msgPrg = document.querySelector("#prg-error");
/** пользователь*/
const user = document.querySelector("#element-username").textContent;
/** контроллер элемента комиссии */
const commissionCtl = new CommissionCtl(url, commissionForm, msgPrg);
/** вебсокет */
const websocket = new AdminClientWebsocket("ws://localhost:8888", user);
