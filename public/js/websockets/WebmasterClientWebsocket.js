/** активные офферы для рекламодателя */
class WebmasterClientWebsocket extends ClientWebsocket
{
    constructor(url, username, activeOfferList) {
        super(url, username);
        this.activeOfferList = activeOfferList;
    }

    onMessage(e) {
        let data = JSON.parse(e.data);
        console.log(data);

        if (data.type === 'NEW_OFFER') {
            // добавляется новый активный оффер
            this.activeOfferList.innerHTML += `
                <article id="${data.offer_id}" class='border-666 mb-1 rounded cursor-pointer bg-light offers__item' draggable='true'>
                    <p class='fw-bolder'>${data.offer_name}</p>
                    <p>цена: ${data.offer_income} р. за переход</p>
                    <p>тема: ${data.offer_theme}</p>
                </article>
            `;            
        } else if (data.type === 'DELETE_OFFER') {
            // удаляется оффер-подписка
            let row = document.querySelector(`#subscription-${data.id}`);
            if (row === null) {
                row = document.querySelector(`#offer-${data.id}`);
            }
            row.remove();
        }
    }
}