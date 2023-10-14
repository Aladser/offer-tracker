document.oncontextmenu = () => false;

/** пользователь*/
const user = document.querySelector("#element-username").textContent;
/** таблица активных офферов */
const activeOffersTable = document.querySelector("#active-offers");
/** таблица выключенных офферов */
const deactiveOffersTable = document.querySelector("#deactive-offers");
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
    activeOffersTable,
    subscriptionStatus
);