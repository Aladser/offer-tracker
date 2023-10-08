/** обновление статистики рекламодателей и вебмастеров */
class StatisticsFrontWebsocket extends FrontWebsocket
{
    constructor(url, offerTable, username) {
        super(url);
        this.offerTable = offerTable; 
        this.username = username.textContent;

        this.totalClicksElement = this.offerTable.querySelector('.table-offers__total-clicks'); 
        this.totalMoneyElement = this.offerTable.querySelector('.table-offers__total-money');
    }

    /** обновляет статистику рекламодателя или вебмастера */
    onMessage(e) {
        let data = JSON.parse(e.data);
        if (data.type !== 'CLICK') {
            return;
        }

        let row = this.offerTable.querySelector(`tr[data-id="${data.offer}"]`);
        if (data.advertiser === this.username) {
            // статистика рекламодателя
            this.refreshCellData(data, row, 'рекламодатель');
        } else if (data.webmaster === this.username) {
            // статистика вебмастера
            this.refreshCellData(data, row, 'веб-мастер');
        }
    }

    // обновить данные ячеек
    refreshCellData(data, row, role) {
        let clickCell = row.querySelector('.table-offers__clicks'); // ячейка числа кликов
        let moneyCell = row.querySelector('.table-offers__money');  // ячейка денежной суммы
        let money = role == 'рекламодатель' ? data.price : data.price * data.income_part;
 
        clickCell.textContent = parseInt(clickCell.textContent) + 1;
        moneyCell.textContent = parseInt(moneyCell.textContent) + money;

        this.totalClicksElement.textContent = parseInt(this.totalClicksElement.textContent) + 1;
        this.totalMoneyElement.textContent = parseInt(this.totalMoneyElement.textContent) + money;
    }
}