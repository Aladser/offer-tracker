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
            this.createOfferElement(data);
        } else if (data.type === 'DELETE_OFFER' || data.type === 'UNVISIBLE_OFFER') {
            // ищется подписка
            let row = document.querySelector(`#subscription-${data.id}`);
            // или ищется активный оффер
            if (row === null) {
                row = document.querySelector(`#offer-${data.id}`);
            }
            // скрывается подписка или активный оффер
            if (row !== null) {
                row.remove();
            }
        } else if (data.type === 'VISIBLE_OFFER') {
            // показывается оффер и подписка на него
            if (data.webmasters.length !== 0) {
                // проверяется, есть ли подписка
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
                } else {
                    this.createOfferElement(data);
                }
            } else {
                this.createOfferElement(data);
            }
        }
    }

    /** показывается активный оффер */
    createOfferElement(data) {
        this.subscriptionCtl.activeOffersList.innerHTML += `
            <article id="offer-${data.offer_id}" class='border-666 mb-1 rounded cursor-pointer bg-light offers__item' draggable='true'>
                <p class='fw-bolder'>${data.offer_name}</p>
                <p>цена: ${data.offer_income} р. за переход</p>
                <p>тема: ${data.offer_theme}</p>
            </article>
        `;
        this.subscriptionCtl.setListeners();
    }
}
