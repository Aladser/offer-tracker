/** обновление реферальных ссылок на главной странице */
class MainClientWebsocket extends ClientWebsocket {
    constructor(url, refList) {
        super(url, null);
        // список активных офферов
        this.refList = refList;
    }

    onMessage(e) {
        let data = JSON.parse(e.data);

        if (data.type == "VISIBLE_OFFER") {
            // показ подписок включенного оффера
            let webmasters = data.webmasters;
            webmasters.forEach((master) => {
                data.offer_refcode = master.refcode;
                data.offer_webmaster = master.name;
                this.#createSubscription(data);
            });
        } else if (data.type == "SUBSCRIBE") {
            this.#createSubscription(data);
        } else if (data.type == "UNSUBSCRIBE") {
            // удаление подписки на оффер
            let offerRefLinks = document.querySelectorAll(
                `article[data-id='${data.offer_id}']`
            );
            offerRefLinks = Array.from(offerRefLinks);
            // childNodes[3] - вебмастер
            let reflink = offerRefLinks.find(
                (link) =>
                    link.childNodes[3].textContent ==
                    `веб-мастер: ${data.webmaster}`
            );
            reflink.remove();
        } else if (
            data.type == "DELETE_OFFER" ||
            data.type == "UNVISIBLE_OFFER"
        ) {
            // удаление реф.ссылок на оффер
            document
                .querySelectorAll(`article[data-id='${data.id}']`)
                .forEach((ref) => ref.remove());
        }
    }

    /** добавление новой подписки на включенный оффер */
    #createSubscription(data) {
        this.refList.innerHTML += `
            <article class='p-3 m-2 text-center bg-ddd color-333 fs-3 shadow rounded' data-id='${data.offer_id}'>
                <a href="?ref=${data.offer_refcode}"><p title="${data.offer_url}">${data.offer_name}</p></a>
                <p>веб-мастер: ${data.offer_webmaster}</p>
                <p>тема: ${data.offer_theme}</p>
            </article>
        `;
    }
}
