class StatisticsFrontWebsocket extends FrontWebsocket
{
    constructor(url, offerTable, username) {
        super(url);
        this.offerTable = offerTable; 
        this.username = username;
    }

    // получение сообщений: изменение числа подписчиков
    onMessage(e) {
        let data = JSON.parse(e.data);
        console.log(data);
    }
}