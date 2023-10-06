class FrontWebsocket
{
    constructor() {
        this.websocket = new WebSocket('ws://localhost:8888');
        this.websocket.onerror = this.onError;
        this.websocket.onmessage = this.onMessage;
        this.websocket.onmessage = this.onopen;
    }

    // получение ошибок вебсокета
    onError (e) {
        console.log(e);
    }

    // получение сообщений
    onMessage(e) {
        let data = JSON.parse(e.data);
        console.log(data);
    }

    // отправка сообщений
    sendData(data) {
        this.websocket.send(JSON.stringify(data));
    }

    onOpen(e) {
        console.log("Соединение установлено");
    };
}