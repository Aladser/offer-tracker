/** поле ошибки */
const prgError = document.querySelector('#prg-error');
/** список офферов-подписок */
const subscriptionsList = document.querySelector('#list-subscriptions');
/** спиоск доступных активных офферов */
const activeOfferList = document.querySelector('#list-active-offers');
// URL бэк-части
const subscribeURL = 'offer/subscribe';
const unsubscribeURL = 'offer/unsubscribe';
/** контроллер подписок */
const subscriptionCtl = new SubscriptionCtl(subscriptionsList, activeOfferList, subscribeURL, unsubscribeURL);
/** пользователь*/
const user = document.querySelector("#element-username").textContent;
/** вебсокет */
const websocket = new WebmasterClientWebsocket('ws://localhost:8888', user, subscriptionCtl);