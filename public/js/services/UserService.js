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
}
