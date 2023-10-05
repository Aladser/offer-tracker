/** Фронт-контроллер таблицы пользователей */
class UserService extends FrontController{
  /** создать строку таблицы
   * 
   * @param {*} data данные из БД
   */
  createRow(data) {
    this.table.querySelector("tbody").innerHTML +=
      `<tr data-id="${data.row.id}" class='table-users__tr position-relative'>` +
      `<td>${data.row.name}</td>` +
      `<td>${data.row.email}</td>` +
      '<td class="p-0">' +
      `<div class='form-switch p-0 h-100'>` +
      '<input type="checkbox" name="status" class="table-offers__input-status form-check-input mx-auto" title="деактивировать" checked></td>' +
      "</td>" +
      `<td>${data.row.role}</td>` +
      "</tr>"
  }

  /** установить статус */
  setStatus(row, inputStatus) {
    let data = new URLSearchParams()
    data.set("id", row.getAttribute("data-id"))
    data.set("status", inputStatus.checked)
    let headers = { "X-CSRF-TOKEN": this.csrfToken.getAttribute("content") }

    let statusSwitch = row.querySelector("input[name='status']")
    fetch(`${this.URL}/status`, {
      method: "post",
      headers: headers,
      body: data,
    })
      .then((response) => response.text())
      .then((rslt) => {
        if (rslt == 1) {
          statusSwitch.title = inputStatus.checked ? "выключить" : "включить"
        } else {
          this.errorPrg.textContent = "серверная ошибка изменения статуса"
          console.log(rslt)
        }
      })
  }
}
