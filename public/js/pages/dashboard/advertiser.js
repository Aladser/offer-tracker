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

/** вебсокет страницы рекламодателя */
const advertiserClientWebsocket = new AdvertiserClientWebsocket(
    "ws://localhost:8888",
    user,
    document.querySelector("#active-offers"),
    subscriptionStatus
);

/** клиентский контроллер таблицы */
const offerTableController = new OfferTableClientController(
    "/offer",
    offersSection,
    document.querySelector("#prg-error"),
    null,
    user
);

/** список видимых офферов */
let offersItems = offersSection.querySelectorAll(".offers__item");
offersItems.forEach((item) => {
    /** наведение мыши на оффер */
    item.onmouseover = () => {
        let btn = item.querySelector(".offers__btn-remove");
        setTimeout(() => btn.classList.remove("d-none"), 400);
    };
    /** уведение мыши c оффера */
    item.onmouseout = () => {
        let btn = item.querySelector(".offers__btn-remove");
        setTimeout(() => btn.classList.add("d-none"), 400);
    };
    /** нажатие мыши на оффер */
    item.onmousedown = () => {
        let btn = item.querySelector(".offers__btn-remove");
        setTimeout(() => btn.classList.remove("d-none"), 400);
    };
});
