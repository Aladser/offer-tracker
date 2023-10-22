/** обновление статистики админа */
class RegisterClientWebsocket extends ClientWebsocket {
    constructor(url, username, userTableClientController) {
        super(url, username);
        this.userTableClientController = userTableClientController;
    }

    onMessage(e) {
        let data = JSON.parse(e.data);
        if (data.type === "NEW_REGISTRATION") {
            console.log(data);
            this.userTableClientController.processData(null, data);
        }
    }
}
