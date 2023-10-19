document.oncontextmenu = () => false;

/** пользователь*/
const user = document.querySelector("#element-username").textContent;
/** секция офферов */
const offersSection = document.querySelector(".offers");
/** контроллер статуса оффера (включен-выключен) */
const subscriptionStatus = new OfferStatus(
    "active-offers",
    "deactive-offers",
    "/offer/status"
);

/** клиентский контроллер таблицы */
const offerTableController = new OfferTableClientController(
    "/offer",
    offersSection,
    document.querySelector("#prg-error"),
    null,
    user
);


// список видимых офферов
let offersItems = offersSection.querySelectorAll(".offers__item");
offersItems.forEach((item) => {
    // наведение мыши на оффер
    item.onmouseover = () => {
        let btn = item.querySelector(".offers__btn-remove");
        setTimeout(() => btn.classList.add("offers__btn-remove--mouseon"), 400);
    };
    // уведение мыши c оффера
    item.onmouseout = () => {
        let btn = item.querySelector(".offers__btn-remove");
        setTimeout(() => btn.classList.remove("offers__btn-remove--mouseon"), 400);
    };
    // нажатие мыши на оффер
    item.onmousedown = () => {
        item.querySelector(".offers__btn-remove").classList.remove("offers__btn-remove--mouseon");
    };
});
