/** Фронт-контроллер таблицы пользователей */
class UserTableClientController extends TableClientController {
    /** создвть строку пользователя в таблице
     * @param {*} form форма добавления
     * @param {*} data данные из БД
     */
    processData(form, data) {
        form.reset();
        this.table.querySelector(
            "tbody"
        ).innerHTML += `<tr id="${data.row.id}" class='table-users__tr position-relative'>
          <td>${data.row.name}</td>
          <td>${data.row.email}</td>
          <td class="p-0">
            <div class='form-switch p-0 h-100'>
            <input type="checkbox" name="status" class="table-offers__input-status form-check-input mx-auto" title="деактивировать" checked></td>
          </td>
          <td>${data.row.role}</td>
        </tr>`;
        this.msgElement.textContent = "";
        // назначаются заново события клика строки
        let tableRows = this.table.querySelectorAll(".table-users__tr");
        tableRows.forEach(row => (row.onclick = e => this.clickRow(e)));
    }

    /** включить/выключить строку в БД
     * @param {*} row cрока
     * @param {*} inputStatus - input статусы строки
     */
    setStatus(row, inputStatus) {
        let data = new URLSearchParams();
        data.set("id", row.id);
        data.set("status", inputStatus.checked);
        let headers = {
            "X-CSRF-TOKEN": this.csrfToken.getAttribute("content"),
        };

        let statusSwitch = row.querySelector("input[name='status']");

        fetch(`${this.URL}/status`, {
            method: "post",
            headers: headers,
            body: data,
        })
            .then((response) => response.text())
            .then((rslt) => {
                if (rslt == 1) {
                    statusSwitch.title = inputStatus.checked
                        ? "выключить"
                        : "включить";
                } else {
                    if (rslt.includes("<title>Page Expired</title>")) {
                        window.open("/wrong-uri", "_self");
                    } else {
                        this.msgElement.textContent =
                            "серверная ошибка изменения статуса";
                        console.log(rslt);
                    }
                }
            });
    }
}
