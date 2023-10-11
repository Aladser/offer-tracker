/**  статистика подписчиков рекламодателя*/
class AdvertiserClientWebsocket extends ClientWebsocket
{
    constructor(url, username, offerTable) {
        super(url, username);
        this.offerTable = offerTable; 
    }

    // получение сообщений: SUBSCRIBE, UNSUBSCRIBE. Изменение числа подписчиков
    onMessage(e) {
        let data = JSON.parse(e.data);
        if (data.type !== 'SUBSCRIBE' && data.type !== 'UNSUBSCRIBE') {
            return;
        }

        // обновление числа подписчиков оффера
        if (data.advertiser === this.username) {
            // оффер, данные которого обновляются
            let row = this.offerTable.querySelector(`tr[data-id="${data.offer_id}"]`);
            // ячейка числа подписчиков
            let counter = row.querySelector('.table-offers__td-link-count'); 
            
            if (data.type == 'SUBSCRIBE') {
                counter.textContent =  parseInt(counter.textContent) + 1;
            } else {
                counter.textContent =  parseInt(counter.textContent) - 1;
            }
        }
    }
}