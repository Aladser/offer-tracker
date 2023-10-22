/** обновление статистики админа */
class RegisterClientWebsocket extends ClientWebsocket {
    constructor(url, username) {
        super(url, username);

        this.userTable = document.querySelector("#table-users");
    }

    onMessage(e) {
        let data = JSON.parse(e.data);
        console.log(data);
        if (data.type === "NEW_REGISTRATION") {
            // добавление в tbody таблицы нового пользователя
            this.userTable.querySelector('tbody').innerHTML += `<tr class="table-users__tr position-relative" data-id="${data.id}"> 
                <td>${data.name}</td>
                <td>${data.email}</td>
                <td class="p-0">
                    <div class="form-switch p-0 h-100">
                        <input type="checkbox" name="status" class="table-offers__input-status form-check-input mx-auto" title="выключить" checked="">
                    </div>
                </td>
                <td class="pe-3">${data.role}</td>
                </tr>`;
        }
    }
}
