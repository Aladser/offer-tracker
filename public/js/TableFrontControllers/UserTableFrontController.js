/** Фронт-контроллер таблицы пользователей */
class UserTableFrontController extends TableFrontController{
  constructor(URL, table, msgElement, form, csrfToken) {
    super(URL, table, msgElement, form, csrfToken);
    // примесь изменения статуса строки
    Object.assign(UserTableFrontController.prototype, statusFunc);
  }

  /** добавить строку в таблицу
   * @param {*} form форма добавления
   * @param {*} data данные из БД
   */
  processData(form, data) {
    form.reset();
    this.table.querySelector("tbody").innerHTML +=
      `<tr data-id="${data.row.id}" class='table-users__tr position-relative'>
          <td>${data.row.name}</td>
          <td>${data.row.email}</td>
          <td class="p-0">
            <div class='form-switch p-0 h-100'>
            <input type="checkbox" name="status" class="table-offers__input-status form-check-input mx-auto" title="деактивировать" checked></td>
          </td>
          <td>${data.row.role}</td>
      </tr>`;
    this.msgElement.textContent = "";
    this.table.querySelectorAll(`.${this.table.id}__tr`).forEach((row) => {
      row.onclick = (e) => this.click(e.target.closest("tr"));
    })
  }
}
