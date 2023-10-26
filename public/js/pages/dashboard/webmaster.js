/** поле ошибки */
const prgError = document.querySelector("#prg-error");
/** список офферов-подписок */
const subscriptionsList = document.querySelector("#list-subscriptions");
/** спиоск доступных активных офферов */
const activeOfferList = document.querySelector("#list-active-offers");
/** контроллер статуса подписки (включен-выключен) */
const subscriptionStatus = new SubscriptionStatus(
    "list-subscriptions",
    "list-active-offers",
    "/offer/subscription"
);

/** вебсокет */
const websocket = new WebmasterClientWebsocket(
    subscriptionsList,
    activeOfferList,
    subscriptionStatus,
    prgError
);
