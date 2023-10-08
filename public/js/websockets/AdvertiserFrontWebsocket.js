/**  статистика подписчиков рекламодателя*/
class AdvertiserFrontWebsocket extends FrontWebsocket
{
    constructor(url, username, offerTable) {
        super(url, username);
        this.offerTable = offerTable; 
    }

    // получение сообщений: изменение числа подписчиков
    onMessage(e) {
        let data = JSON.parse(e.data);
        if (data.type !== 'SUBSCRIBE' && data.type !== 'UNSUBSCRIBE') {
            return;
        }

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