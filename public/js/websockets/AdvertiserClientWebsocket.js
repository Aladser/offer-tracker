/**  статистика подписчиков рекламодателя*/
class AdvertiserClientWebsocket extends ClientWebsocket {
   // получение сообщений: SUBSCRIBE, UNSUBSCRIBE
    onMessage(e) {
        let data = JSON.parse(e.data);
        if (data.type !== "SUBSCRIBE" && data.type !== "UNSUBSCRIBE") {
            return;
        }

        // обновление числа подписчиков оффера
        if (data.advertiser === this.username) {
            // оффер, данные которого обновляются
            let row = document.getElementById(data.offer_id);
            // ячейка числа подписчиков
            let counter = row.querySelector(".table-offers__td-link-count");
            // вырезает число подписчиков
            let followersCount = parseInt(counter.textContent.substring(13));
            // обновляет число подписчиков на странице рекламодателя
            followersCount += data.type == "SUBSCRIBE" ? 1 : -1;
            counter.textContent = `Подписчиков: ${followersCount}`;
        }
    }
}
