/**  статистика подписчиков рекламодателя*/
class AdvertiserClientWebsocket extends ClientWebsocket
{
    constructor(url, username, offerTable) {
        super(url, username);
        this.offerTable = offerTable; 
    }

    // получение сообщений SUBSCRIBE, UNSUBSCRIBE: изменение числа подписчиков
    onMessage(e) {
        let data = JSON.parse(e.data);
        if (data.type !== 'SUBSCRIBE' && data.type !== 'UNSUBSCRIBE') {
            return;
        }

        // обновление страницы рекламодателя, создателя оффера
        if (data.advertiser === this.username) {   
            let row = this.offerTable.querySelector(`tr[data-id="${data.offer}"]`);
            let counter = row.querySelector('.table-offers__td-link-count'); 
            if (data.type == 'SUBSCRIBE') {
                counter.textContent =  parseInt(counter.textContent) + 1;
            } else {
                counter.textContent =  parseInt(counter.textContent) - 1;
            }
        }
    }
}