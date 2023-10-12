/** список офферов-подписок */
const activeOfferListList = document.querySelector('#active-offers');
/** спиоск доступных активных офферов */
const deactiveOfferListList = document.querySelector('#deactive-offers');
/** контроллер подписок */
const offerStatus = new OfferStatus(activeOfferListList, deactiveOfferListList, '/offer/status');