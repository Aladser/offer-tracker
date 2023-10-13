/**  статистика подписчиков рекламодателя*/
class AdvertiserClientWebsocket extends ClientWebsocket
{
    constructor(url, username, offerTable, subscriptionStatus) {
        super(url, username);
        this.offerTable = offerTable; 
        this.subscriptionStatus = subscriptionStatus;
    }

    // получение сообщений: SUBSCRIBE, UNSUBSCRIBE. Изменение числа подписчиков
    onMessage(e) {
        let data = JSON.parse(e.data);
        //console.log(data);
        if (data.type !== 'SUBSCRIBE' && data.type !== 'UNSUBSCRIBE') {
            return;
        }

        // обновление числа подписчиков оффера
        if (data.advertiser === this.username) {
            // оффер, данные которого обновляются
            let row = document.getElementById(data.offer_id);
            // ячейка числа подписчиков
            let counter = row.querySelector('.table-offers__td-link-count');
            let followersCount = parseInt(counter.textContent.substring(13));
            
            if (data.type == 'SUBSCRIBE') {
                counter.textContent =  'Подписчиков: ' + ++followersCount;
            } else {
                counter.textContent =  'Подписчиков: ' + --followersCount;
            }
        }
    }
}