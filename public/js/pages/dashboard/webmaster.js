/** поле ошибки */
const prgError = document.querySelector("#prg-error");
/** список офферов-подписок */
const subscriptionsList = document.querySelector("#list-subscriptions");
/** спиоск доступных активных офферов */
const activeOfferList = document.querySelector("#list-active-offers");
/** пользователь*/
const user = document.querySelector("#element-username").textContent;
/** контроллер статуса подписки (включен-выключен) */
const subscriptionStatus = new SubscriptionStatus(
    "list-subscriptions",
    "list-active-offers",
    "/offer/subscription"
);
/** вебсокет */
const websocket = new WebmasterClientWebsocket(
    "ws://localhost:8888",
    user,
    subscriptionsList,
    activeOfferList,
    subscriptionStatus,
    prgError
);
