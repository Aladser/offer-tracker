/** обновление статистики админа */
class MainClientWebsocket extends ClientWebsocket {
    constructor(refList) {
        super();
        // список активных офферов
        this.refList = refList;
    }

    /** получение типов сообщений: NEW_OFFER*/
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
            // если кто-то из вебмастеров подписался от оффера
            this.#createSubscription(data);
        } else if (data.type == "UNSUBSCRIBE") {
            // если кто-то из вебмастеров отписался от оффера
            // удаление подписки на оффер со страницы
            let offerRefLinks = document.querySelectorAll(
                `article[data-id='${data.offer_id}']`
            );
            offerRefLinks = Array.from(offerRefLinks);
            // childNodes[3] - вебмастер
            // поиск подписки текущего вебмастера на оффер сообщения
            let reflink = offerRefLinks.find(
                (link) =>
                    link.childNodes[3].textContent ==
                    `веб-мастер: ${data.webmaster}`
            );
            // удаление рефссылки с главной страницы
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
            <article class='p-4 m-2 text-center bg-ddd color-333 shadow rounded text-xl w-80 space-y-2' data-id='${data.offer_id}'>
                <a href="?ref=${data.offer_refcode}" class="font-semibold"><p title="${data.offer_url}">${data.offer_name}</p></a>
                <p>веб-мастер: ${data.offer_webmaster}</p>
                <p>тема: ${data.offer_theme}</p>
            </article>
        `;
    }
}