/** Фронт-контроллер таблицы пользователей */
class UserTableClientController extends TableClientController {
    /** клик строки */
    clickRow(e) {
        // переключатель меняет статус стрки
        if (e.target.tagName === "INPUT") {
            this.setStatus(e.target.closest("tr"), e.target);
        } else {
            this.click(e.target.closest("tr"));
        }
    }

    /** создать строку пользователя в таблице страницы
     * @param {*} form форма добавления
     * @param {*} data данные из БД
     */
    processData(row, form = null) {
        // очистка формы, если добавляются данные из формы
        if (form !== null) {
            form.reset();
        }

        this.table.querySelector(
            "tbody"
        ).innerHTML += `
            <tr id="${row.id}" class='table-users__tr relative'> 
                <td class='p-2'>${row.name}</td>
                <td class='p-2'>${row.email}</td>
                
                <td class='p-2'>
                    <label class='switch'>
                        <input type="checkbox" name="status" class='table-offers__input-status mx-auto' title='выключить' checked> 
                        <span class="slider round"></span>
                    </label>
                </td>
                <td class='p-2'>${row.role}</td>
            </tr>
        `;
        this.msgElement.textContent = "";
        // назначаются заново события клика строки
        let tableRows = this.table.querySelectorAll(".table-users__tr");
        tableRows.forEach((row) => (row.onclick = (e) => this.clickRow(e)));
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
