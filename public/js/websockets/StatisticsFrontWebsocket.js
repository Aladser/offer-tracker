/** обновление статистики рекламодателей и вебмастеров */
class StatisticsFrontWebsocket extends FrontWebsocket
{
    constructor(url, offerTable, username) {
        super(url);
        this.offerTable = offerTable; 
        this.username = username.textContent;
    }

    /** обновляет статистику рекламодателя или вебмастера */
    onMessage(e) {
        let data = JSON.parse(e.data);
        if (data.type !== 'CLICK') {
            return;
        }

        let row = this.offerTable.querySelector(`tr[data-id="${data.offer}"]`);
        let clickCell = row.querySelector('.table-offers__clicks'); // ячейка числа кликов
        let moneyCell = row.querySelector('.table-offers__money');  // ячейка денежной суммы
        if (data.advertiser === this.username) {
            // статистика рекламодателя
            clickCell.textContent = parseInt(clickCell.textContent) + 1;
            moneyCell.textContent = parseInt(moneyCell.textContent) + data.price;
        } else if (data.webmaster === this.username) {
            // статистика вебмастера
            clickCell.textContent = parseInt(clickCell.textContent) + 1;
            moneyCell.textContent = parseInt(moneyCell.textContent) + (data.price * data.income_part);
        }
    }
}