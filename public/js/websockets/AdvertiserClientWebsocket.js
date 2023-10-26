/**  статистика подписчиков рекламодателя*/
class AdvertiserClientWebsocket extends ClientWebsocket {
   // получение сообщений: SUBSCRIBE, UNSUBSCRIBE - изменение числа подписчиков
    onMessage(e) {
        let data = JSON.parse(e.data);
        //console.log(data);
        if (data.type !== "SUBSCRIBE" && data.type !== "UNSUBSCRIBE") {
            return;
        }

        // обновление числа подписчиков оффера
        if (data.advertiser === this.username) {
            // оффер, данные которого обновляются
            let row = document.getElementById(data.offer_id);
            // ячейка числа подписчиков
            let counter = row.querySelector(".table-offers__td-link-count");
            // выречает число подписчиков
            let followersCount = parseInt(counter.textContent.substring(13));
            // обновляет число подписчиков на странице рекламодателя
            if (data.type == "SUBSCRIBE") {
                counter.textContent = "Подписчиков: " + (followersCount + 1);
            } else {
                counter.textContent = "Подписчиков: " + (followersCount - 1);
            }
        }
    }
}
