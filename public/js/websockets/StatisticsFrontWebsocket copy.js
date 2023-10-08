/** обновление статистики рекламодателей и вебмастеров */
class StatisticsFrontWebsocket extends FrontWebsocket
{
    constructor(url, offerTables, username) {
        super(url);
        this.username = username.textContent;
    }

    /** обновляет статистику рекламодателя или вебмастера */
    onMessage(e) {
        let data = JSON.parse(e.data);
        if (data.type !== 'CLICK') {
            return;
        }

        console.log(data);
    }
}