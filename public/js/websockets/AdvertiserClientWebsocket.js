/**  статистика подписчиков рекламодателя*/
class AdvertiserClientWebsocket extends ClientWebsocket {
    constructor(url, username, offerTable, msgPrg) {
        super(url, username);
        this.offerTable = offerTable;
        this.msgPrg = msgPrg;
    }

    onMessage(e) {
        let data = JSON.parse(e.data);
        if ((data.type == "SUBSCRIBE" || data.type == "UNSUBSCRIBE")) {
            if (data.advertiser === this.username) {
                // оффер, данные которого обновляются
                let row = document.getElementById(data.offer_id);
                // ячейка числа подписчиков
                let counter = row.querySelector(".table-offers__td-link-count");
                // выречает число подписчиков
                let followersCount = parseInt(counter.textContent.substring(13));
    
                if (data.type == "SUBSCRIBE") {
                    counter.textContent = "Подписчиков: " + (followersCount + 1);
                } else {
                    counter.textContent = "Подписчиков: " + (followersCount - 1);
                }
            }
        } else if (data.type == "ADDED_NEW_OFFER") {
            if (data.result == 1) {
                this.msgPrg.textContent = `оффер ${data.offer_name} добавлен`;
            } else {
                this.msgPrg.textContent = data.description;
            }
        }
    }
}
