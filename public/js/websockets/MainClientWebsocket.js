/** обновление статистики админа */
class MainClientWebsocket extends ClientWebsocket
{
    constructor(url, refList) {
        super(url, null);
        // список актвиных офферов
        this.refList = refList;
    }

    onMessage(e) {
        let data = JSON.parse(e.data);
        console.clear();
        console.log(data);
        
        if (data.type == 'NEW_OFFER' && data.hasOwnProperty('offer_url')) {
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
        } else {
            // удаление реф.ссылок на оффер
            document.querySelectorAll(`article[data-id='${data.id}']`).forEach(ref => ref.remove());
        }
    }
}