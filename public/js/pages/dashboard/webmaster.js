/** поле ошибки */
const prgError = document.querySelector('#prg-error');

const subscribeURL = 'offer/subscribe';
const unsubscribeURL = 'offer/unsubscribe';
// офферы-подписки
const subscriptionsList = document.querySelector('#list-subscriptions');
// доступные активные офферы
const activeOffersList = document.querySelector('#list-active-offers');

// контроллер подписок
const subscriptionCtl = new SubscriptionCtl(subscriptionsList, activeOffersList, subscribeURL, unsubscribeURL);

/** вебсокет */
const websocket = new FrontWebsocket('ws://localhost:8888');