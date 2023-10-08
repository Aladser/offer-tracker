/** Статистика рекламодателей и вебмастеров */
class StatisticsFrontWebsocket extends FrontWebsocket
{
    constructor(url, username, offerTables) {
        super(url, username);
        this.offerTables = offerTables;
    }

    /** обновляет статистику рекламодателя или вебмастера */
    onMessage(e) {
        let data = JSON.parse(e.data);
        if (data.type !== 'CLICK' || !(data.advertiser === this.username || data.webmaster === this.username)) {
            return;
        }

        let rows = [];
        // обновляется строка оффера каждой таблицы
        this.offerTables.forEach(table => {
            let cells = table.querySelectorAll(`tr[data-id="${data.offer}"] td`);
            let rowCount =  table.childNodes[1].childNodes.length;
            // (последняя-2) строка - строка итогов
            let lastRow = table.childNodes[1].childNodes[rowCount-2].childNodes; 
            rows.push({
                'clickCell':cells[1], // ячейка числа переходов оффера
                'moneyCell':cells[2], // ячейка денежной суммы оффера
                'totalClicksElement':lastRow[3], // ячейка общего числа переходов
                'totalMoneyElement':lastRow[5] // ячейка общей денежной суммы
            });
        });

        if (data.advertiser === this.username) {
            // статистика рекламодателя
            this.refreshCellData(data, rows, 'рекламодатель');
        } else {
            // статистика вебмастера
            this.refreshCellData(data, rows, 'веб-мастер');
        }
    }

    // обновить данные ячеек
    refreshCellData(data, rows, role) {
        rows.forEach(row => {
            // величина расхода рекламодателя или доход вебмастера за переход
            let money = role == 'рекламодатель' ? data.price : data.price * data.income_part;
     
            row.clickCell.textContent = parseInt(row.clickCell.textContent) + 1;
            row.moneyCell.textContent = parseInt(row.moneyCell.textContent) + money;
    
            row.totalClicksElement.textContent = parseInt(row.totalClicksElement.textContent) + 1;
            row.totalMoneyElement.textContent = parseInt(row.totalMoneyElement.textContent) + money;
        });
    }
}