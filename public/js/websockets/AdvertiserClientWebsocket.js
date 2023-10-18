/**  статистика подписчиков рекламодателя*/
class AdvertiserClientWebsocket extends ClientWebsocket {
    constructor(url, username, offerTable, msgPrg) {
        super(url, username);
        this.offerTable = offerTable;
        this.msgPrg = msgPrg;
    }

    onMessage(e) {
        let data = JSON.parse(e.data);
        // получение новых подписок и отписок
        if (data.type == "SUBSCRIBE" || data.type == "UNSUBSCRIBE") {
            if (data.advertiser === this.username) {
                // оффер, данные которого обновляются
                let row = document.getElementById(data.offer_id);
                // ячейка числа подписчиков
                let counter = row.querySelector(".table-offers__td-link-count");
                // вырезает число подписчиков
                let followersCount = parseInt(
                    counter.textContent.substring(13)
                );
                counter.textContent =
                    "Подписчиков: " + data.type == "SUBSCRIBE"
                        ? followersCount + 1
                        : followersCount + 1;
            }
            // сообщения о новых офферах
        } else if (data.type == "ADDED_NEW_OFFER") {
            this.msgPrg.textContent =
                data.result == 1
                    ? `оффер ${data.offer_name} добавлен`
                    : data.description;
        }
    }
}
