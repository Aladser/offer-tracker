/** пользователь*/
const user = document.querySelector("#element-username").textContent;
/** таблица офферов */
const offerTable = document.querySelector("#active-offers");
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
    offerTable,
    subscriptionStatus
);
