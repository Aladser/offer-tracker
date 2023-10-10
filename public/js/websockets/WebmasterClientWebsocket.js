/** активные офферы для рекламодателя */
class WebmasterClientWebsocket extends ClientWebsocket
{
    constructor(url, username, subscriptionCtl) {
        super(url, username);
        this.subscriptionCtl = subscriptionCtl;
    }

    onMessage(e) {
        let data = JSON.parse(e.data);
        if (data.type === 'NEW_OFFER') {
            let webmaster = data.webmasters.find(master => master.name == this.username);

            if (webmaster !== undefined) {
                // показывается подписка вебмастера
                this.subscriptionCtl.subscriptionsList.innerHTML += `
                    <article id="subscription-${data.offer_id}" class='border-666 mb-1 rounded cursor-pointer subscriptions__item' draggable='true'>
                        <p class='fw-bolder'>${data.offer_name}</p>
                        <p>цена: ${data.offer_income} р. за переход</p>
                        <p>тема: ${data.offer_theme}</p>
                        <a href="?ref=${webmaster.refcode}" title="?ref=${webmaster.refcode}" class='fw-bolder fs-5 text-primary subscriptions__ref'>Реферальная ссылка</a>
                    </article>
                `;
                // восстанавливается обработчик событий
                let subscription = this.subscriptionCtl.subscriptionsList.querySelector(`#subscription-${data.offer_id}`);
                subscription.ondragstart = e => this.subscriptionCtl.onDragStart(e);
            } else {
                // добавляется новый активный оффер
                this.subscriptionCtl.activeOffersList.innerHTML += `
                    <article id="offer-${data.offer_id}" class='border-666 mb-1 rounded cursor-pointer bg-light offers__item' draggable='true'>
                        <p class='fw-bolder'>${data.offer_name}</p>
                        <p>цена: ${data.offer_income} р. за переход</p>
                        <p>тема: ${data.offer_theme}</p>
                    </article>
                `;
                // восстанавливается обработчик событий
                let offer = this.subscriptionCtl.activeOffersList.querySelector(`#offer-${data.offer_id}`);
                offer.ondragstart = e => this.subscriptionCtl.onDragStart(e);
            }
        } else if (data.type === 'DELETE_OFFER') {
            // удаляется оффер-подписка
            let row = document.querySelector(`#subscription-${data.id}`);
            if (row === null) {
                // удаляется активный оффер
                row = document.querySelector(`#offer-${data.id}`);
            }
            row.remove();
        }
    }
}