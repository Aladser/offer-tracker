/** обновление статистики админа */
class AdminFrontWebsocket extends FrontWebsocket
{
    constructor(url, username) {
        super(url, username);

        this.subscriptions = document.querySelector('#table-admin-statistics__subscriptions');
        this.clicks = document.querySelector('#table-admin-statistics__clicks');
        this.systemIncome = document.querySelector('#table-admin-statistics__system-income');
        this.failedClicks = document.querySelector('#table-admin-statistics__failed_clicks');
    }

    onMessage(e) {
        let data = JSON.parse(e.data);
        console.log(data);

        if (data.type === 'CLICK') {
            // число кликов
            this.clicks.textContent = parseInt(this.clicks.textContent) + 1;
            // доход системы
            let income = parseFloat(this.systemIncome.textContent);
            let commission = ((1-data.income_part)*data.price).toFixed(2);
            this.systemIncome.textContent = (parseFloat(income) + parseFloat(commission)).toFixed(2) + ' руб.';
        } else if(data.type === 'SUBSCRIBE') {
            // увеличивается число подписок
            this.subscriptions.textContent = parseInt(this.subscriptions.textContent) + 1;
        } else if(data.type === 'UNSUBSCRIBE') {
            // уменьшается число подписок
            this.subscriptions.textContent = parseInt(this.subscriptions.textContent) - 1;
        } else if(data.type === 'FAILED_OFFER') {
            // инкремент числа отказов реферальных ссылок
            this.failedClicks.textContent = parseInt(this.failedClicks.textContent) + 1;
        }
    }
}