// форма комиссиии
const commissionForm = document.querySelector("#form-change-commission");
/** поле результата добавления */
const msgPrg = document.querySelector("#prg-error");
/** контроллер элемента комиссии */
const commissionCtl = new CommissionCtl("/commission", commissionForm, msgPrg);
/** пользователь*/
const user = document.querySelector("#element-username").textContent;

/** вебсокет */
const websocket = new AdminClientWebsocket(user);
