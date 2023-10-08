/** базовый класс клиентского вебсокета */
class FrontWebsocket
{
    constructor(url, username) {
        this.websocket = new WebSocket(url);
        this.websocket.onerror = e => this.onError(e);
        this.websocket.onmessage = e => this.onMessage(e);
        this.websocket.onopen = e => this.onOpen(e);
        this.username = username;
    }

    // получение ошибок вебсокета
    onError (e) {
        alert(`ошибка вебсокета ${e}`);
    }

    // получение сообщений
    onMessage(e) {
        let data = JSON.parse(e.data);
        //console.log(data);
    }

    // отправка сообщений
    sendData(data) {
        this.websocket.send(JSON.stringify(data));
    }

    onOpen(e) {
        
    }; 
}