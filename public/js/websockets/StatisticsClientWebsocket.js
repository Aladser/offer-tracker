/** Статистика рекламодателей и вебмастеров */
class StatisticsClientWebsocket extends ClientWebsocket
{
    constructor(url, username, offerTables) {
        super(url, username);
        this.offerTables = offerTables;
    }

    /** обновляет строку таблицы статистики рекламодателя или вебмастера */
    onMessage(e) {
        let data = JSON.parse(e.data);
        if (data.type !== 'CLICK' || !(data.advertiser === this.username || data.webmaster === this.username)) {
            return;
        }

        let rows = [];
        // обновляется строка в каждой таблице
        this.offerTables.forEach(table => {
            let rowCount =  table.childNodes[1].childNodes.length;
            // ячейки изменяемой строки
            let cells = table.querySelectorAll(`tr[data-id="${data.offer}"] td`);
            // таблица => (последняя-2) строка - строка итогов => ячейки строки
            let lastRow = table.childNodes[1].childNodes[rowCount-2].childNodes; 
            rows.push({
                'clickCell':cells[1], // ячейка числа переходов оффера
                'moneyCell':cells[2], // ячейка денежной суммы оффера
                'totalClicksElement':lastRow[3], // ячейка общего числа переходов
                'totalMoneyElement':lastRow[5] // ячейка общей денежной суммы
            });
        });

        this.refreshCellData(data, rows, data.advertiser === this.username ? 'рекламодатель' : 'веб-мастер');
    }

    /** обновить данные ячеек строки */
    refreshCellData(data, rows, role) {
        //строка в каждой таблице
        rows.forEach(row => {
            // величина расхода рекламодателя или доход вебмастера за переход
            let money = role == 'рекламодатель' ? data.price : data.price * data.income_part;
     
            row.clickCell.textContent = parseInt(row.clickCell.textContent) + 1;
            row.moneyCell.textContent = (parseFloat(row.moneyCell.textContent) + money).toFixed(2)  + ' р.';
    
            row.totalClicksElement.textContent = parseInt(row.totalClicksElement.textContent) + 1;
            row.totalMoneyElement.textContent = (parseInt(row.totalMoneyElement.textContent) + money).toFixed(2) + ' р.';
        });
    }
}