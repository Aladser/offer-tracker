class FrontWebsocket
{
    constructor()
    {
        this.websocket = new WebSocket('ws://localhost:8888');
        this.websocket.onerror = this.onError;
        this.websocket.onmessage = e => this.onMessage(e);
    }

    // получение ошибок вебсокета
    onError = (e) => console.log(e);

    // получение сообщений
    onMessage(e)
    {
        let data = JSON.parse(e.data);
        console.log(data);
    }

    // отправка сообщений
    sendData(data)
    {
        this.websocket.send(JSON.stringify(data));
    }
}