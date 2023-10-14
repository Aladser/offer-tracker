/** пользователь*/
const user = document.querySelector("#element-username").textContent;

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
    document.querySelector('.offers'),
    document.querySelector('#prg-error'),
    null,
    user
);


document.oncontextmenu = () => false;