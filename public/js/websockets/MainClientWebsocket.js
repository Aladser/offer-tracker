/** обновление статистики админа */
class MainClientWebsocket extends ClientWebsocket
{
    constructor(url, refList) {
        super(url, null);
        // список активных офферов
        this.refList = refList;
    }

    /** получение типов сообщений: NEW_OFFER*/
    onMessage(e) {
        let data = JSON.parse(e.data);
        //console.log(data);

        if (data.type == 'NEW_OFFER' && data.hasOwnProperty('offer_url')) {
            // добавление реф.ссылок 
            let webmasters = data.webmasters;
            webmasters.forEach(master => {
                this.refList.innerHTML += `
                    <article class='p-3 m-2 text-center bg-ddd color-333 fs-3 shadow rounded' data-id='${data.offer_id}'>
                        <a href="?ref=${master.refcode}"><p title="${data.offer_url}">${data.offer_name}</p></a>
                        <p>веб-мастер:${master.name}</p>
                        <p>тема: ${data.offer_theme}</p>
                    </article>
                `;
            });
        } else if (data.type == 'DELETE_OFFER') {
            // удаление реф.ссылок на оффер
            document.querySelectorAll(`article[data-id='${data.id}']`).forEach(ref => ref.remove());
        } else if(data.type == 'SUBSCRIBE') {
            // добавление новой реферальной ссылки
            this.refList.innerHTML += `
                <article class='p-3 m-2 text-center bg-ddd color-333 fs-3 shadow rounded' data-id='${data.offer_id}'>
                    <a href="?ref=${data.offer_refcode}"><p title="${data.offer_url}">${data.offer_name}</p></a>
                    <p>веб-мастер:${data.offer_webmaster}</p>
                    <p>тема: ${data.offer_theme}</p>
                </article>
            `;
        } else if(data.type == 'UNSUBSCRIBE') {
            // удаление реферальной ссылки
            let offerRefLinks = document.querySelectorAll(`article[data-id='${data.offer}']`);
            offerRefLinks.forEach(link => console.log(link));
            // childNodes[3] - вебмастер
            offerRefLinks = Array.from(offerRefLinks);
            let reflink = offerRefLinks.find(link => link.childNodes[3].textContent == `веб-мастер:${data.webmaster}`);
            console.log(reflink);
            //reflink.remove();
        }
    }
}