/** Статистика рекламодателей и вебмастеров */
class StatisticsClientWebsocket extends ClientWebsocket {
    constructor(offerTables) {
        super();
        this.offerTables = offerTables;
    }

    /**Обновляет строку таблицы статистики рекламодателя или вебмастера.
     * 
     * Так на странице четыре таблицы на каждый временной промежуток, нужно в каждой обновить соответствующую строку
    */
    onMessage(e) {
        let data = JSON.parse(e.data);
        if (
            data.type !== "CLICK" ||
            !(
                data.advertiser === this.username ||
                data.webmaster === this.username
            )
        ) {
            return;
        }

        let rows = [];
        // обновляется строка в каждой таблице
        this.offerTables.forEach((table) => {
            // ячейки изменяемой строки
            let cells = table.querySelectorAll(
                `tr[data-id="${data.offer}"] td`
            );
            rows.push({
                clickCell: cells[1], // ячейка числа переходов оффера
                moneyCell: cells[2], // ячейка денежной суммы оффера
                totalClicksElement: table.querySelector('.table-offers__total-clicks'), // ячейка общего числа переходов
                totalMoneyElement: table.querySelector('.table-offers__total-money'), // ячейка общей денежной суммы
            });
        });

        this.refreshCellData(
            data,
            rows,
            data.advertiser === this.username ? "рекламодатель" : "веб-мастер"
        );
    }

    /** обновить данные ячеек строки */
    refreshCellData(data, rows, role) {
        //строка в каждой таблице
        rows.forEach((row) => {
            // величина расхода рекламодателя или доход вебмастера за переход
            let money =
                role == "рекламодатель"
                    ? data.price
                    : data.price * data.income_part;

            row.clickCell.textContent = parseInt(row.clickCell.textContent) + 1;
            row.moneyCell.textContent =
                parseFloat(row.moneyCell.textContent) + money + " р.";

            row.totalClicksElement.textContent =
                parseInt(row.totalClicksElement.textContent) + 1;
            row.totalMoneyElement.textContent =
                parseInt(row.totalMoneyElement.textContent) + money + " р.";
        });
    }
}
